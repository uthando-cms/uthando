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


use Uthando\Core\Form\FormBase;
use Uthando\User\Entity\DTO\Login;
use Uthando\User\Service\AuthenticationManager;
use Zend\Authentication\Result;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\Prg\PostRedirectGet;
use Zend\Session\Container;
use Zend\Uri\Uri;
use Zend\View\Model\ViewModel;

/**
 * Class AuthController
 * @package Uthando\User\Controller
 * @method Request getRequest()
 * @method PostRedirectGet prg()
 */
class AuthController extends AbstractActionController
{
    /**
     * @var AuthenticationManager
     */
    protected $authManager;

    /**
     * @var AnnotationBuilder
     */
    protected $formBuilder;

    /**
     * @var Container|\stdClass
     */
    protected $sessionContainer;

    public function __construct(AuthenticationManager $authManager, AnnotationBuilder $builder, Container $sessionContainer)
    {
        $this->authManager      = $authManager;
        $this->formBuilder      = $builder;
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * @return HttpResponse|PostRedirectGet|ViewModel
     * @throws \Exception
     */
    public function loginAction()
    {
        /** @var FormBase $form */
        $form = $this->formBuilder->createForm(Login::class);
        $prg  = $this->prg();

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            if (isset($this->sessionContainer->redirectUrl)) {

                $form->get('redirect_url')->setValue(
                    $this->sessionContainer->redirectUrl
                );

                unset($this->sessionContainer->redirectUrl);
            }

            return new ViewModel([
                'form' => $form,
            ]);
        }

        $form->bind(new Login());
        $form->setData((array) $prg);

        if ($form->isValid()) {

            /** @var Login $dto */
            $dto        = $form->getData();
            $authResult = $this->authManager->doAuthentication($dto);

            if (Result::SUCCESS === $authResult->getCode()) {

                $uri = new Uri($dto->redirectUrl);

                if ($uri->isValid() && null === $uri->getHost()) {
                    return $this->redirect()->toUrl($dto->redirectUrl);
                } else {
                    return $this->redirect()->toRoute('home');
                }
            }
        }

        $isLoginError = true;

        return new ViewModel([
            'form'          => $form,
            'isLoginError'  => $isLoginError,
        ]);
    }

    /**
     * @return HttpResponse
     * @throws \Exception
     */
    public function logoutAction()
    {
        $this->authManager->clear();
        return $this->redirect()->toRoute('login');
    }
}