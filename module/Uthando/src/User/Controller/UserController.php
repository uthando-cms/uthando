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
use Uthando\User\Entity\DTO\ChangePassword;
use Uthando\User\Entity\DTO\PasswordReset;
use Uthando\User\Service\UserManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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

    public function resetPasswordAction()
    {
        $form = $this->formBuilder->createForm(PasswordReset::class);

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function setPasswordAction()
    {
        $form = $this->formBuilder->createForm(ChangePassword::class);
        return new ViewModel([
            'form' => $form,
        ]);
    }
}