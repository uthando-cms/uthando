<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\User\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoTest\User\Controller;

use Uthando\Core\Form\FormBase;
use Uthando\User\Controller\UserController;
use Uthando\User\Entity\DTO\PasswordReset;
use Uthando\User\Entity\UserEntity;
use UthandoTest\Framework\HttpControllerTestCase;
use Zend\Form\Annotation\AnnotationBuilder;

class UserControllerTest extends HttpControllerTestCase
{
    /**
     * @dataProvider userRouteProvider
     * @param string $url
     * @throws \Exception
     */
    public function testGuestCannotAccessUserActions(string $url)
    {
        $this->dispatch($url);

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }

    public function userRouteProvider(): array
    {
        return [
            'Index Action'          => ['/user'],
            'Update Details Action' => ['/user/update-details'],
            'Set Password Action'   => ['/user/set-password'],
        ];
    }

    public function testUserCanAccessProfile()
    {
        $this->adminLogin();
        $this->dispatch('/user');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('user');
        $this->assertActionName('index');
    }

    public function testUserCanAccessUpdateDetailsAction()
    {
        $this->userLogin();
        $this->dispatch('/user/update-details');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('user/update-details');
        $this->assertActionName('update-details');
    }

    public function testUserCanUpdateTheirDetails()
    {
        $this->userLogin();

        $postData = [
            'email'     => 'jane@example.com',
            'firstname' => 'Jane',
            'lastname'  => 'Doe',
            'old_email' => 'user@example.com',
            'csrf'      => $this->getCsrfValue('/user/update-details'),
        ];

        $this->dispatch('/user/update-details', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/user/update-details');

        $numRows = $this->getConnection()->getRowCount('users', 'email = "jane@example.com"');

        $this->assertSame(1, $numRows);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/user/view');
    }

    public function testInvalidUserDetailsRendersForm()
    {
        $this->userLogin();

        $postData = [
            'email'     => 'admin@example.com',
            'firstname' => '',
            'lastname'  => 'Doe',
            'old_email' => 'user@example.com',
        ];

        $this->dispatch('/user/update-details', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/user/update-details');

        $numRows = $this->getConnection()->getRowCount('users', 'email = "user@example.com"');

        $this->assertSame(1, $numRows);

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('user/update-details');
        $this->assertActionName('update-details');
    }

    public function testUserCanAccessChangePasswordAction()
    {
        $this->userLogin();
        $this->dispatch('/user/change-password');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('user/change-password');
        $this->assertActionName('change-password');
    }

    public function testUserCanChangePassword()
    {
        $this->userLogin();

        $postData = [
            'old_password'          => 'password',
            'new_password'          => 'new-password',
            'confirm_new_password'  => 'new-password',
            'csrf'                  => $this->getCsrfValue('/user/change-password'),
        ];

        $this->dispatch('/user/change-password', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/user/change-password');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/user/view');

        $this->assertTrue(UserEntity::verifyPassword(
            $this->getSessionUser(), 'new-password'
        ));
    }

    public function testInvalidPasswordRendersForm()
    {
        $this->userLogin();

        $postData = [
            'old_password'          => '',
            'new_password'          => 'new-password',
            'confirm_new_password'  => 'wrong-new-password',
            'csrf'                  => $this->getCsrfValue('/user/change-password'),
        ];

        $this->dispatch('/user/change-password', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/user/change-password');

        $numRows = $this->getConnection()->getRowCount('users', 'email = "user@example.com"');

        $this->assertSame(1, $numRows);

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('user/change-password');
        $this->assertActionName('change-password');
    }

    public function testInvalidOldPasswordRedirectsToProfile()
    {
        $this->userLogin();

        $postData = [
            'old_password'          => 'bad-password',
            'new_password'          => 'new-password',
            'confirm_new_password'  => 'new-password',
            'csrf'                  => $this->getCsrfValue('/user/change-password'),
        ];

        $this->dispatch('/user/change-password', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/user/change-password');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/user/view');

        $this->assertFalse(UserEntity::verifyPassword(
            $this->getSessionUser(), 'new-password'
        ));
    }

    public function testGuestCanAccessResetPasswordAction()
    {
        $this->dispatch('/reset-password');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('reset-password');
        $this->assertActionName('reset-password');
    }

    public function testInvalidResetPasswordRedendersForm()
    {
        $postData = [
            'email' => 'admin@example.com',
            'csrf'  => $this->getCsrfValue('/reset-password'),
        ];

        $this->dispatch('/reset-password', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/reset-password');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('reset-password');
        $this->assertActionName('reset-password');
    }

    /**
     * @throws \Exception
     * @dataProvider emailDataProvider
     */
    public function testCanValidateResetTokenWith($email, $assertQuery)
    {
        $postData = [
            'email'     => $email,
            'csrf'      => $this->getCsrfValue('/reset-password'),
            'captcha'   => '',
        ];

        $this->dispatch('/reset-password', 'POST', $postData);
        $this->reset(true);

        /** @var AnnotationBuilder $builder */
        $builder     = $this->getApplicationServiceLocator()->get(AnnotationBuilder::class);

        /** @var FormBase $form */
        $form        = $builder->createForm(PasswordReset::class);
        $mockBuilder = $this->prophesize(AnnotationBuilder::class);

        $form->remove('captcha');

        $mockBuilder->createForm(PasswordReset::class)->willReturn($form);

        $this->getApplicationServiceLocator()->setAllowOverride(true);
        $this->getApplicationServiceLocator()->setService(AnnotationBuilder::class, $mockBuilder->reveal());
        $this->getApplicationServiceLocator()->setAllowOverride(false);

        $this->dispatch('/reset-password');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserController::class);
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('reset-password');
        $this->assertActionName('reset-password');
        $this->assertTemplateName('uthando/user/user/message');
        $this->assertQuery($assertQuery);
    }

    public function emailDataProvider()
    {
        return [
            ' with correct email' => ['admin@example.com', 'p.message-sent'],
            ' with invalid email' => ['inactive@example.com', 'p.invalid-email'],
        ];
    }
}
