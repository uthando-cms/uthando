<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Uthando\Blog\Controller
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/18
 * @license   see LICENSE
 */

namespace Uthando\Blog\Controller;


use Uthando\Blog\Entity\DTO\AddComment;
use Uthando\Blog\Entity\PostEntity;
use Uthando\Blog\Repository\PostRepository;
use Uthando\Blog\Service\PostManager;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;

/**
 * Class PostController
 *
 * @package Uthando\Blog\Controller
 * @method  Request getRequest()
 * @method Response getResponse()
 */
final class PostController extends AbstractActionController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PostManager
     */
    private $postManager;

    /**
     * @var AnnotationBuilder
     */
    private $formBuilder;

    public function __construct(PostRepository $postRepository, PostManager $postManager, AnnotationBuilder $formBuilder)
    {
        $this->postRepository   = $postRepository;
        $this->postManager      = $postManager;
        $this->formBuilder      = $formBuilder;
    }

    /**
     *
     * @return ViewModel
     * @throws \Exception
     */
    public function indexAction() : ViewModel
    {
        $filter = $this->params()->fromRoute('tag');
        $page   = $this->params()->fromRoute('page', 1);

        if ($filter) {
            $posts = $this->postRepository->findPostsByTagName($filter);
        } else {
            $posts = $this->postRepository->findBy(
                ['status' => PostEntity::STATUS_PUBLISHED],
                ['dateCreated' => 'DESC']
            );
        }

        $adaptor    = new ArrayAdapter($posts);
        $paginator  = new Paginator($adaptor);

        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $tagCloud = $this->postRepository->fetchTagCount();

        return new ViewModel([
            'posts'         => $paginator,
            'tagCloud'      => $tagCloud,
            'route'         => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'routeParams'   => $this->getEvent()->getRouteMatch()->getParams(),
        ]);
    }

    /**
     * @return ViewModel|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function viewAction()
    {
        $seo = $this->params()->fromRoute('seo');

        $post = $this->postRepository->findOneBy(['seo' => $seo]);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
        }

        $form = $this->formBuilder->createForm(AddComment::class);

        // Check whether this post-admin is a POST request.
        if($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            $form->bind(new AddComment());

            if($form->isValid()) {

                // Use post-admin manager service to add new comment to post-admin.
                $this->postManager->addCommentToPost($post, $form->getData());

                // Redirect the user again to "view" page.
                return $this->redirect()->toRoute('blog/post', ['seo' => $seo]);
            }
        }

        $tagCloud = $this->postRepository->fetchTagCount();

        return new ViewModel([
            'post'      => $post,
            'form'      => $form,
            'tagCloud'  => $tagCloud,
        ]);
    }
}
