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
use UthandoTest\Framework\HttpControllerTestCase;

class AdminControllerTest extends HttpControllerTestCase
{
    public function testAdminCanAccessIndexAction()
    {
        $this->login();
        $this->dispatch('/admin');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(AdminController::class);
        $this->assertControllerClass('AdminController');
        $this->assertMatchedRouteName('admin');
    }

    public function testGuestGetsRedirectedToLogin()
    {
        $this->dispatch('/admin');

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }
}
