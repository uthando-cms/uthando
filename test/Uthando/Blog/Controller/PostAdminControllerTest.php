<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Post\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoTest\Post\Controller;


use Uthando\Blog\Controller\PostAdminController;
use UthandoTest\Framework\HttpControllerTestCase;

class PostAdminControllerTest extends HttpControllerTestCase
{
    /**
     * @dataProvider postRouteProvider
     * @param string $url
     * @throws \Exception
     */
    public function testGuestCannotAccessPostActions(string $url)
    {
        $this->dispatch($url);

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }

    public function postRouteProvider(): array
    {
        return [
            'Index Action'  => ['/admin/posts'],
            'Add Action'    => ['/admin/posts/add'],
            'Edit Action'   => ['/admin/posts/edit'],
            'Delete Action' => ['/admin/posts/delete'],
        ];
    }

    public function testAdminCanAccessPostsList()
    {
        $this->adminLogin();

        $this->dispatch('/admin/posts');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostAdminController::class);
        $this->assertControllerClass('PostAdminController');
        $this->assertMatchedRouteName('admin/post-admin');
        $this->assertActionName('index');
    }

    public function testCanAddNewPost()
    {
        $this->adminLogin();

        $postData = [
            'status'    => '0',
            'title'     => 'Filtering HTML in Zend Framework Using HTML Purifier',
            'seo'       => '',
            'content'   => 'If you have forms where you allow users to submit HTML content you will want to filter that so you can be sure that no malicious code gets through, some WYSIWYG editors do this but not all but still as we are paranoid backend developers we don\'t trust any input submitted by users.',
            'tags'      => [
                'aa4fa2c7-506a-4889-9810-af14f36b2b87',
                '3f17611e-13de-4439-929d-1396943d3c4e',
                ],
            'new_tags'  => 'Html Purifier',
            'csrf'      => $this->getCsrfValue('/admin/posts/add'),
        ];

        $this->dispatch('/admin/posts/add', 'POST', $postData);

        $this->assertSame(
            4,
            $this->getConnection()->getRowCount('posts'),
            "Inserting failed"
        );

        $this->assertSame(
            9,
            $this->getConnection()->getRowCount('tags'),
            "Inserting failed"
        );

        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostAdminController::class);
        $this->assertControllerClass('PostAdminController');
        $this->assertMatchedRouteName('admin/post-admin');
        $this->assertRedirectTo('/admin/posts');
    }

    /**
     * @dataProvider editUpdateProvider
     * @param array $postData
     * @param int $expectedPosts
     * @param int $expectedTags
     * @throws \Exception
     */
    public function testCanEditPost(array $postData, int $expectedPosts, int $expectedTags)
    {
        $this->adminLogin();

        $postCount = $this->getConnection()->getRowCount('posts');
        $tagCount = $this->getConnection()->getRowCount('tags');

        $postData['csrf'] = $this->getCsrfValue('/admin/posts/edit/5af686fb-5ba5-4157-8115-cf075a43c2d3');

        $this->dispatch('/admin/posts/edit/5af686fb-5ba5-4157-8115-cf075a43c2d3', 'POST', $postData);

        $this->assertSame(
            $expectedPosts,
            $this->getConnection()->getRowCount('posts'),
            "updating failed"
        );

        $this->assertSame(
            $expectedTags,
            $this->getConnection()->getRowCount('tags'),
            "Inserting failed"
        );

        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostAdminController::class);
        $this->assertControllerClass('PostAdminController');
        $this->assertMatchedRouteName('admin/post-admin');
        $this->assertRedirectTo('/admin/posts');
    }

    public function editUpdateProvider(): array
    {
        return [
            'update modified date' => [[
                'id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3',
                'status' => '0',
                'title' => 'How to Install MySQL or MariaDB on CentOS 7',
                'seo' => 'how-to-install-mysql-or-mariadb-on-centos-7',
                'content' => 'As of CentOS 7 the default database is MariaDB and a drop in replacement for MySQL and should be fine for most people but if you need MySQL, there are some features in MySQL and not in MariaDB and vice versa.',
                'date_created' => '2018-08-20T19:18:50+00:00',
                'date_modified' => '2018-08-20T19:18:50+00:00',
                'tags'      => [],
                'new_tags'  => 'CSS, PHP',
                'old_seo'   => 'how-to-install-mysql-or-mariadb-on-centos-7',
            ], 3, 9],
            'update all dates' => [[
                'id' => '5af686fb-5ba5-4157-8115-cf075a43c2d3',
                'status' => '1',
                'title' => 'How to Install MySQL or MariaDB on CentOS 7',
                'seo' => 'how-to-install-mysql-or-mariadb-on-centos-7',
                'content' => 'As of CentOS 7 the default database is MariaDB and a drop in replacement for MySQL and should be fine for most people but if you need MySQL, there are some features in MySQL and not in MariaDB and vice versa.',
                'tags'      => [
                    'aa4fa2c7-506a-4889-9810-af14f36b2b87',
                ],
                'new_tags'  => 'Html Purifier',
                'old_seo'   => 'how-to-install-mysql-or-mariadb-on-centos-7',
            ], 3, 9],

        ];
    }

    /**
     * @dataProvider notExistingIdProvider
     * @param $action
     * @param $id
     * @throws \Exception
     */
    public function testNonExistingPostReturns404(string $action, string $id)
    {
        $this->adminLogin();

        $postData = [
            'id' => $id,
        ];

        $this->dispatch('/admin/posts/' . $action . '/' . $id, 'POST', $postData);
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

        $this->dispatch('/admin/posts/' . $action . '/' . $id, 'POST', $postData);
        $this->assertResponseStatusCode(500);
    }

    public function invalidIdProvider(): array
    {
        return [
            'edit action'   => ['edit', 'c4d11f76-3afb-4733-8a053df794c1'],
            'delete action' => ['delete', '776ceb09-f300-48bc-b400'],
        ];

    }

    /**
     * @dataProvider idProvider
     * @param $id
     * @throws \Exception
     */
    public function testAdminCanDeletePost(string $id)
    {
        $this->adminLogin();

        $noOfPosts = $this->getConnection()->getRowCount('posts');

        $postData = [
            'id' => $id,
        ];

        $this->dispatch('/admin/posts/delete', 'POST', $postData);

        $this->assertSame(
            ($noOfPosts - 1),
            $this->getConnection()->getRowCount('posts'),
            "Delete failed"
        );

        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostAdminController::class);
        $this->assertControllerClass('PostAdminController');
        $this->assertMatchedRouteName('admin/post-admin');
        $this->assertRedirectTo('/admin/posts');
    }

    public function idProvider(): array
    {
        return [
            'ID 1' => ['5af686fb-5ba5-4157-8115-cf075a43c2d3'],
            'ID 2' => ['6ffbdc8e-546d-4da2-8e78-43bde918c864'],
            'ID 3' => ['e610d563-a408-42b4-8445-1db708ef714e'],
        ];

    }
}
