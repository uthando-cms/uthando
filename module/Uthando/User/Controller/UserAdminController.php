<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\User\Controller;


use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;
use Uthando\User\Entity\DTO\AddUser;
use Uthando\User\Entity\DTO\EditUser;
use Uthando\User\Entity\UserEntity;
use Uthando\User\Service\UserManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

/**
 * Class UserAdminController
 * @package Uthando\User\Controller
 * @method Request getRequest()
 * @method Response getResponse()
 * @method UserEntity identity()
 */
final class UserAdminController extends AbstractActionController
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var EntityRepository
     */
    protected $userRepository;

    /**
     * @var AnnotationBuilder
     */
    protected $formBuilder;

    public function __construct(EntityRepository $entityRepository, UserManager $userManager, AnnotationBuilder $formBuilder)
    {
        $this->formBuilder      = $formBuilder;
        $this->userRepository   = $entityRepository;
        $this->userManager      = $userManager;
    }

    public function indexAction()
    {
        $page   = $this->params()->fromRoute('page', 1);

        // Get recent posts
        $posts = $this->userRepository
            ->findBy([], ['dateCreated'=>'DESC']);

        $adaptor    = new ArrayAdapter($posts);
        $paginator  = new Paginator($adaptor);

        $paginator->setDefaultItemCountPerPage(25);
        $paginator->setCurrentPageNumber($page);

        // Render the view template
        return new ViewModel([
            'users' => $paginator,
        ]);
    }

    /**
     * @return array|\Zend\Http\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addAction()
    {
        $form = $this->formBuilder->createForm(AddUser::class);

        // Check whether this post-admin is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            $form->bind(new AddUser());

            if ($form->isValid()) {
                /** @var AddUser $dto */
                $dto = $form->getData();
                $this->userManager->addUser($dto);
                // Redirect the user to "post" page.
                return $this->redirect()->toRoute('admin/user-admin');
            }
        }

        return [
            'form' => $form,
        ];
    }

    /**
     * @return bool|\Zend\Http\Response|ViewModel
     * @throws \Exception
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!Uuid::isValid($id)) {
            throw new \Exception(sprintf('Not a valid UUID: %s', $id));
        }

        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (null === $user) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $form = $this->formBuilder->createForm(EditUser::class);
        $form->bind(new EditUser());
        $form->setData($user->getArrayCopy());
        $form->get('old_email')->setValue($user->email);

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {
            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);

            if ($form->isValid()) {
                /** @var EditUser $dto */
                $dto = $form->getData();

                // sanity check: current user cannot make themselves inactive.
                if (UserEntity::STATUS_INACTIVE === $dto->status && $user === $this->identity()) {
                    $dto->status = UserEntity::STATUS_ACTIVE;
                }

                // Use post manager service to add new post-admin to database.
                $this->userManager->updateUser($user, $dto);

                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('admin/user-admin');
            }
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'user' => $user,
        ]);
    }

    /**
     * @return bool|\Zend\Http\Response
     * @throws \Exception
     */
    public function deleteAction()
    {
        $id   = $this->params()->fromPost('id');
        $user = $this->identity();

        if (!Uuid::isValid($id)) {
            throw new \Exception(sprintf('Not a valid UUID: %s', $id));
        }

        // cannot delete yourself
        if ($id === $user->id->toString()) {
            $this->getResponse()->setStatusCode(302);
            return $this->redirect()->toRoute('admin/user-admin');
        }

        /** @var UserEntity $user */
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (null === $user) {
            return $this->getResponse()->setStatusCode(404);
        }

        $this->userManager->removeUser($user);

        // Redirect the user to "post" page.
        return $this->redirect()->toRoute('admin/user-admin');
    }
}