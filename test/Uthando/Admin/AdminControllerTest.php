<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Admin
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Admin;

use Uthando\Admin\Controller\AdminController;
use Uthando\User\Entity\DTO\Login;
use Uthando\User\Service\AuthenticationManager;
use UthandoTest\Framework\HttpControllerTestCase;

class AdminControllerTest extends HttpControllerTestCase
{
    public function testAdminCanAccessIndexAction()
    {
        ob_start();
        ini_set('memory_limit', '256M');
        /** @var AuthenticationManager $auth */
        $auth = $this->getApplicationServiceLocator()
            ->get(AuthenticationManager::class);

        $dto = new Login();
        $dto->email = 'admin@example.com';
        $dto->password = 'password';

        $result = $auth->doAuthentication($dto);

        $this->dispatch('/admin');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(AdminController::class);
        $this->assertControllerClass('AdminController');
        $this->assertMatchedRouteName('admin');
        ob_end_flush();
    }

    public function testGuestRedirectsToLogin()
    {
        $this->dispatch('/admin');

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }
}
