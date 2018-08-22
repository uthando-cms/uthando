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

use Uthando\User\Controller\UserAdminController;
use UthandoTest\Framework\HttpControllerTestCase;

class UserAdminControllerTest extends HttpControllerTestCase
{
    /**
     * @dataProvider userRouteProvider
     * @param string $url
     * @throws \Exception
     */
    public function testGuestCannotAccessUserAdminActions(string $url)
    {
        $this->dispatch($url);

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }

    public function userRouteProvider(): array
    {
        return [
            'Index Action'  => ['/admin/users'],
            'Add Action'    => ['/admin/users/add'],
            'Edit Action'   => ['/admin/users/edit'],
            'Delete Action' => ['/admin/users/delete'],
        ];
    }

    public function testAdminCanAccessUsersList()
    {
        $this->adminLogin();

        $this->dispatch('/admin/users');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserAdminController::class);
        $this->assertControllerClass('UserAdminController');
        $this->assertMatchedRouteName('admin/user-admin');
        $this->assertActionName('index');
    }
}
