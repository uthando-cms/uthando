<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   User\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace User\Controller;


use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;
use User\Entity\DTO\AddUser;
use User\Entity\DTO\EditUser;
use User\Service\UserManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

/**
 * Class UserAdminController
 * @package User\Controller
 * @method Request getRequest()
 * @method Response getResponse()
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

                $this->userManager->addUser($form->getData());
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

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $form = $this->formBuilder->createForm(EditUser::class);
        $form->bind(new EditUser());
        $form->setData($user->getArrayCopy());

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {
            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);

            if ($form->isValid()) {

                // Use post manager service to add new post-admin to database.
                $this->userManager->updateUser($user, $form->getData());

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

    public function deleteAction()
    {

    }
}