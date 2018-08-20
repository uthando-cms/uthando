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
    public function testGuestCannotAccessAdminRoute()
    {
        $this->dispatch('/admin/posts');

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/login');
    }

    public function testAdminCanAccessPostsList()
    {
        $this->login();

        $this->dispatch('/admin/posts');

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostAdminController::class);
        $this->assertControllerClass('PostAdminController');
        $this->assertMatchedRouteName('admin/post-admin');
        $this->assertActionName('index');
    }

    public function testCanAccessAddPostAction()
    {
        $this->login();

        $this->dispatch('/admin/posts/add');

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostAdminController::class);
        $this->assertControllerClass('PostAdminController');
        $this->assertMatchedRouteName('admin/post-admin');
        $this->assertActionName('add');
    }

    public function testCanAddNewPost()
    {
        $this->login();

        $postData = [
            'status'    => '0',
            'title'     => 'Filtering HTML in Zend Framework Using HTML Purifier',
            'seo'       => '',
            'content'   => 'If you have forms where you allow users to submit HTML content you will want to filter that so you can be sure that no malicious code gets through, some WYSIWYG editors do this but not all but still as we are paranoid backend developers we don\'t trust any input submitted by users.',
            'tags'      => [
                '2b748225-218d-458c-b2a1-a0dc20f41d5b',
                '57fc7ae9-6565-47cb-aeb3-ab9446f6f217',
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
        $this->login();

        $postCount = $this->getConnection()->getRowCount('posts');
        $tagCount = $this->getConnection()->getRowCount('tags');

        $postData['csrf'] = $this->getCsrfValue('/admin/posts/edit/4ef5bf8a-fbac-4518-afe9-3a59deb6f726');

        $this->dispatch('/admin/posts/edit/4ef5bf8a-fbac-4518-afe9-3a59deb6f726', 'POST', $postData);

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

    /**
     * @dataProvider notExistingIdProvider
     * @param $action
     * @param $id
     * @throws \Exception
     */
    public function testNonExistingPostReturns404(string $action, string $id)
    {
        $this->login();

        $postData = [
            'id' => $id,
        ];

        $this->dispatch('/admin/posts/' . $action . '/' . $id, 'POST', $postData);
        $this->assertResponseStatusCode(404);
    }

    /**
     * @dataProvider invalidIdProvider
     * @param $action
     * @param $id
     * @throws \Exception
     */
    public function testInvalidIdThrowsException(string $action, string $id)
    {
        $this->login();

        $postData = [
            'id' => $id,
        ];

        $this->dispatch('/admin/posts/' . $action . '/' . $id, 'POST', $postData);
        $this->assertResponseStatusCode(500);
    }

    /**
     * @dataProvider idProvider
     * @param $id
     * @throws \Exception
     */
    public function testAdminCanDeletePost(string $id)
    {
        $this->login();

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

    public function editUpdateProvider(): array
    {
        return [
            'update all dates' => [[
                'status' => '1',
                'title' => 'Twitter Bootstrap - Making a Professional Looking Site',
                'seo' => 'twitter-bootstrap-making-a-professional-looking-site',
                'content' => 'Twitter Bootstrap (shortly, Bootstrap) is a popular CSS framework allowing to make your website professionally looking and visually appealing, even if you don\'t have advanced designer skills.',
                'tags'      => [
                    '2b748225-218d-458c-b2a1-a0dc20f41d5b',
                    '57fc7ae9-6565-47cb-aeb3-ab9446f6f217',
                ],
                'new_tags'  => 'Html Purifier',
                'old_seo'   => 'twitter-bootstrap-making-a-professional-looking-site',
            ], 3, 9],
            'update modified date' => [[
                'status' => '0',
                'title' => 'Twitter Bootstrap - Making a Professional Looking Site',
                'seo' => 'twitter-bootstrap-making-a-professional-looking-site',
                'content' => 'Twitter Bootstrap (shortly, Bootstrap) is a popular CSS framework allowing to make your website professionally looking and visually appealing, even if you don\'t have advanced designer skills.',
                'tags'      => [
                    '2b748225-218d-458c-b2a1-a0dc20f41d5b',
                    '57fc7ae9-6565-47cb-aeb3-ab9446f6f217',
                ],
                'new_tags'  => 'CSS',
                'old_seo'   => 'twitter-bootstrap-making-a-professional-looking-site',
            ], 3, 8],
        ];
    }

    public function notExistingIdProvider(): array
    {
        return [
            'edit action'   => ['edit', 'c4d11f76-3afb-4733-ad03-8a053df794a2'],
            'delete action' => ['delete', 'c4d11f76-3afb-4733-ad03-8a053df794d2'],
        ];
    }

    public function invalidIdProvider(): array
    {
        return [
            'edit action'   => ['edit', 'c4d11f76-3afb-4733-8a053df794c1'],
            'delete action' => ['delete', '776ceb09-f300-48bc-b400'],
        ];

    }

    public function idProvider(): array
    {
        return [
            'ID 1' => ['c4d11f76-3afb-4733-ad03-8a053df794c1'],
            'ID 2' => ['4ef5bf8a-fbac-4518-afe9-3a59deb6f726'],
            'ID 3' => ['776ceb09-f300-48bc-b400-0fd524532e6d'],
        ];

    }
}
