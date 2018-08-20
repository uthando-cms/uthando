<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Post\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Post\Controller;

use Uthando\Blog\Controller\PostController;
use UthandoTest\Framework\HttpControllerTestCase;

class PostControllerTest extends HttpControllerTestCase
{
    protected $postRepository;

    public function testCanAccessPostListByHomeRoute()
    {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('home');
        $this->assertActionName('index');
    }

    public function testCanAccessPostListByBlogRoute()
    {
        $this->dispatch('/blog');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('blog');
        $this->assertActionName('index');
    }

    public function testCanAccessPostsByTag()
    {
        $this->dispatch('/blog/tag/php');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('blog/list');
        $this->assertActionName('index');
    }

    public function testCanAccessPostsByPageNumber()
    {
        $this->dispatch('/blog/page/1');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('blog/list');
        $this->assertActionName('index');
    }

    public function testCanAccessPostsByTagAndPageNumber()
    {
        $this->dispatch('/blog/tag/php/page/1');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('blog/list');
        $this->assertActionName('index');
    }

    public function testCanAccessPostViewBySeo()
    {
        $this->dispatch('/blog/getting-started-with-magento-extension-development-book-review');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('blog/post');
        $this->assertActionName('view');
    }

    public function testGet404WhenAccessingPostWithInvalidSeo()
    {
        $this->dispatch('/blog/getting-started-with-magento-extension-development-book');
        $this->assertResponseStatusCode(404);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('blog/post');
        $this->assertActionName('view');
    }

    public function testCanAddCommentToBlogPost()
    {
        $postData = [
            'author'  => 'Jane Biggles',
            'content' => 'Excellent Post Bro!',
            'csrf'    => $this->getCsrfValue('/blog/a-free-book-about-zend-framework'),
        ];

        $this->dispatch('/blog/a-free-book-about-zend-framework', 'POST', $postData);

        $this->assertSame(
            2,
            $this->getConnection()->getRowCount('comments'),
            "Inserting failed"
        );

        $this->assertResponseStatusCode(302);

        $this->assertModuleName('Uthando');
        $this->assertControllerName(PostController::class);
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('blog/post');
        $this->assertActionName('view');
    }
}
