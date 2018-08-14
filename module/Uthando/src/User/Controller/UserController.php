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
use Uthando\User\Entity\DTO\PasswordReset;
use Uthando\User\Entity\UserEntity;
use Uthando\User\Service\UserManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\Prg\PostRedirectGet;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package Uthando\User\Controller
 * @method PostRedirectGet prg()
 * @method UserEntity|null identity()
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
        return new ViewModel([]);
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

    public function setPasswordAction()
    {
        $user = $this->identity();

        /** @var FormBase $form */
        $form   = $this->formBuilder->createForm(ChangePassword::class);
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
}