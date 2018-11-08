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

    public function testCanAddNewUser()
    {
        $this->adminLogin();

        $postData = [
            'email'             => 'new-user@example.com',
            'firstname'         => 'New',
            'lastname'          => 'User',
            'password'          => 'new-user',
            'confirm_password'  => 'new-user',
            'status'            => '1',
            'csrf'              => $this->getCsrfValue('/admin/users/add'),
        ];

        $this->dispatch('/admin/users/add', 'POST', $postData);

        $this->assertSame(
            4,
            $this->getConnection()->getRowCount('users'),
            "Inserting failed"
        );

        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserAdminController::class);
        $this->assertControllerClass('UserAdminController');
        $this->assertMatchedRouteName('admin/user-admin');
        $this->assertRedirectTo('/admin/users');
    }

    public function testCanEditUser()
    {
        $this->adminLogin();

        $postData = [
            'email'             => 'admin@example.com',
            'firstname'         => 'Joe',
            'lastname'          => 'Admin',
            'status'            => '0',
            'old_email'         => 'admin@example.com',
            'csrf'              => $this->getCsrfValue('/admin/users/edit/d1b265d5-8ab2-4fd8-8bcd-8bdf697324d0'),
        ];

        $this->dispatch('/admin/users/edit/d1b265d5-8ab2-4fd8-8bcd-8bdf697324d0', 'POST', $postData);


        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserAdminController::class);
        $this->assertControllerClass('UserAdminController');
        $this->assertMatchedRouteName('admin/user-admin');
        $this->assertRedirectTo('/admin/users');
    }

    public function testEditingUserWithInvalidValuesRendersForm()
    {
        $this->adminLogin();

        $postData = [
            'email'             => '',
            'firstname'         => 'Joe',
            'lastname'          => 'Admin',
            'status'            => '0',
            'old_email'         => 'admin@example.com',
            'csrf'              => $this->getCsrfValue('/admin/users/edit/d1b265d5-8ab2-4fd8-8bcd-8bdf697324d0'),
        ];

        $this->dispatch('/admin/users/edit/d1b265d5-8ab2-4fd8-8bcd-8bdf697324d0', 'POST', $postData);


        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserAdminController::class);
        $this->assertControllerClass('UserAdminController');
        $this->assertMatchedRouteName('admin/user-admin');
        $this->assertActionName('edit');
    }

    /**
     * @dataProvider notExistingIdProvider
     * @param $action
     * @param $id
     * @throws \Exception
     */
    public function testNonExistingUserReturns404(string $action, string $id)
    {
        $this->adminLogin();

        $postData = [
            'id' => $id,
        ];

        $this->dispatch('/admin/users/' . $action . '/' . $id, 'POST', $postData);
        $this->assertResponseStatusCode(404);
    }

    public function notExistingIdProvider(): array
    {
        return [
            'edit action'   => ['edit', 'c4d11f76-3afb-4733-ad03-8a053df794a2'],
            'delete action' => ['delete', 'c4d11f76-3afb-4733-ad03-8a053df794d2'],
        ];
    }

    /**
     * @dataProvider invalidIdProvider
     * @param $action
     * @param $id
     * @throws \Exception
     */
    public function testInvalidIdThrowsException(string $action, string $id)
    {
        $this->adminLogin();

        $postData = [
            'id' => $id,
        ];

        $this->dispatch('/admin/users/' . $action . '/' . $id, 'POST', $postData);
        $this->assertResponseStatusCode(500);
    }

    public function invalidIdProvider(): array
    {
        return [
            'edit action'   => ['edit', 'c4d11f76-3afb-4733-8a053df794c1'],
            'delete action' => ['delete', '776ceb09-f300-48bc-b400'],
        ];

    }

    public function testAdminCanDeleteUser()
    {
        $this->adminLogin();

        $noOfUsers = $this->getConnection()->getRowCount('users');

        $postData = [
            'id' => 'e204c45d-ef8c-4c59-8e16-e4c45492981f',
        ];

        $this->dispatch('/admin/users/delete', 'POST', $postData);

        $this->assertSame(
            ($noOfUsers - 1),
            $this->getConnection()->getRowCount('users'),
            "Delete failed"
        );

        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserAdminController::class);
        $this->assertControllerClass('UserAdminController');
        $this->assertMatchedRouteName('admin/user-admin');
        $this->assertRedirectTo('/admin/users');
    }

    public function testUserCannotDeleteThemselves()
    {
        $this->adminLogin();

        $postData = [
            'id' => 'd1b265d5-8ab2-4fd8-8bcd-8bdf697324d0',
        ];

        $this->dispatch('/admin/users/delete', 'POST', $postData);

        $this->assertSame(
            3,
            $this->getConnection()->getRowCount('users'),
            "Deleted oneself!"
        );

        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(UserAdminController::class);
        $this->assertControllerClass('UserAdminController');
        $this->assertMatchedRouteName('admin/user-admin');
        $this->assertRedirectTo('/admin/users');
    }
}
