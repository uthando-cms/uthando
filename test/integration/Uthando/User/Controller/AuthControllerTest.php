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

use Uthando\User\Controller\AuthController;
use UthandoTest\Framework\HttpControllerTestCase;
use Zend\Authentication\AuthenticationService;
use Zend\Dom\Document;
use Zend\Dom\Document\Query;

class AuthControllerTest extends HttpControllerTestCase
{
    public function testGuestCanAccessLogin()
    {
        $this->dispatch('/login');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(AuthController::class);
        $this->assertControllerClass('AuthController');
        $this->assertMatchedRouteName('login');
        $this->assertActionName('login');
    }

    public function testGuestCannotAccessLogout()
    {
        $this->dispatch('/logout');

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }

    public function testAuthenticatedUserCanLogout()
    {
        $this->adminLogin();
        /** @var AuthenticationService $auth */
        $auth = $this->getApplicationServiceLocator()->get(AuthenticationService::class);
        $this->assertTrue($auth->hasIdentity(), 'Pre logout state failed.');

        $this->dispatch('/logout');

        $this->assertFalse($auth->hasIdentity(), 'Post logout state failed.');
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }

    public function testLoginValidationFail()
    {
        $postData = [
            'email'     => 'admin@example.com',
            'password'  => 'bad-password',
            'redirect_url' => '',
            'csrf' => $this->getCsrfValue('/login'),
        ];

        $this->dispatch('/login', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/login');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(AuthController::class);
        $this->assertControllerClass('AuthController');
        $this->assertMatchedRouteName('login');
        $this->assertActionName('login');
    }

    public function testCanSetRedirectUrlFromSession()
    {
        $session = $this->getApplicationServiceLocator()->get('UthandoDefault');
        $session->redirectUrl = '/admin';
        $this->dispatch('/login');

        $this->assertNull($session->redirectUrl);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(AuthController::class);
        $this->assertControllerClass('AuthController');
        $this->assertMatchedRouteName('login');
        $this->assertActionName('login');

        $response   = $this->getResponse();
        $document   = new Document($response->getContent());
        $query      = new Query();
        $redirectValue = $query->execute('form input[name="redirect_url"]', $document, Query::TYPE_CSS)
            ->current()
            ->getAttribute('value');

        $this->assertSame('/admin', $redirectValue);
    }

    /**
     * @dataProvider loginDataProvider
     * @param array $postData
     * @param string $expectedRedirectUrl
     * @throws \Exception
     */
    public function testUserLogin(array $postData, string $expectedRedirectUrl)
    {
        $postData['csrf'] = $this->getCsrfValue('/login');

        /** @var AuthenticationService $auth */
        $auth = $this->getApplicationServiceLocator()->get(AuthenticationService::class);
        $this->assertFalse($auth->hasIdentity(), 'Pre login state failed.');

        $this->dispatch('/login', 'POST', $postData);
        $this->reset(true);

        $this->dispatch('/login');

        $this->assertTrue($auth->hasIdentity(), 'Post login state failed.');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect($expectedRedirectUrl);
    }

    public function loginDataProvider()
    {
        return [
            ' without redirect url' => [[
                'email'     => 'admin@example.com',
                'password'  => 'password',
                'redirect_url' => ''
            ], '/'],
            ' with redirect url' => [[
                'email'     => 'admin@example.com',
                'password'  => 'password',
                'redirect_url' => '/admin'
            ], '/admin'],
        ];
    }
}
