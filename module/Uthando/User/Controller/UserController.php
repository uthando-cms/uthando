<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\User\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\User\Controller;


use Doctrine\ORM\EntityRepository;
use Uthando\Core\Form\FormBase;
use Uthando\User\Entity\DTO\ChangePassword;
use Uthando\User\Entity\DTO\EditProfile;
use Uthando\User\Entity\DTO\PasswordReset;
use Uthando\User\Entity\UserEntity;
use Uthando\User\Service\UserManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Mvc\Plugin\Prg\PostRedirectGet;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package Uthando\User\Controller
 * @method PostRedirectGet prg()
 * @method UserEntity|null identity()
 * @method FlashMessenger flashMessenger()
 */
final class UserController extends AbstractActionController
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
        $user = $this->identity();

        return new ViewModel([
            'user' => $user,
        ]);
    }

    public function updateDetailsAction()
    {
        $user   = $this->identity();
        /** @var FormBase $form */
        $form   = $this->formBuilder->createForm(EditProfile::class);
        $prg    = $this->prg();

        $form->bind(new EditProfile());
        $form->remove('status');

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            $form->setData($user->getArrayCopy());
            $form->get('old_email')->setValue($user->email);

            return new ViewModel([
                'form' => $form,
                'user' => $user,
            ]);
        }

        $form->setData((array) $prg);

        if ($form->isValid()) {
            $user   = $this->identity();

            $this->userManager->updateUser($user, $form->getData());

            $this->flashMessenger()->addSuccessMessage(
                'Changes were made successfully.'
            );

            // Redirect to "view" page
            return $this->redirect()->toRoute('user/view');
        }

        return new ViewModel([
            'form' => $form,
            'user' => $user,
        ]);
    }

    public function resetPasswordAction()
    {
        /** @var FormBase $form */
        $form   = $this->formBuilder->createForm(PasswordReset::class);
        $prg    = $this->prg();

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            return new ViewModel([
                'form' => $form,
            ]);
        }

        $form->bind(new PasswordReset());
        $form->setData((array) $prg);

        if ($form->isValid()) {

        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

    /**
     * @return PostRedirectGet|ViewModel|Response
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setPasswordAction()
    {
        /** @var FormBase $form */
        $form   = $this->formBuilder->createForm(ChangePassword::class);
        $prg    = $this->prg();

        $form->bind(new ChangePassword());

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {

            return new ViewModel([
                'form' => $form,
            ]);
        }

        $form->setData((array) $prg);

        if ($form->isValid()) {
            $user   = $this->identity();
            $result = $this->userManager->changePassword($user, $form->getData());

            if (true === $result) {
                $this->flashMessenger()->addSuccessMessage(
                    'Changed the password successfully.');
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'Sorry, the old password is incorrect. Could not set the new password.');
            }

            // Redirect to "view" page
            return $this->redirect()->toRoute('user/view');
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }
}