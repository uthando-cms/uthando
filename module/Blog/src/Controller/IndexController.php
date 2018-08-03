<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Blog\Controller
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/18
 * @license   see LICENSE
 */

namespace Blog\Controller;


use Blog\Entity\CommentEntity;
use Blog\Entity\PostEntity;
use Blog\Repository\PostRepository;
use Blog\Service\PostManager;
use Zend\Form\Form;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;

/**
 * Class IndexController
 *
 * @package Blog\Controller
 * @method  Request getRequest()
 * @method Response getResponse()
 */
final class IndexController extends AbstractActionController
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
     * @var Form
     */
    private $form;

    public function __construct(PostRepository $postRepository, PostManager $postManager, Form $form)
    {
        $this->postRepository   = $postRepository;
        $this->postManager      = $postManager;
        $this->form             = $form;
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
     * @return bool|ViewModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     */
    public function viewAction(): ViewModel
    {
        $id = $this->params()->fromRoute('id');

        $post = $this->postRepository->findOneBy(['id' => $id]);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $form = $this->form;

        // Check whether this post is a POST request.
        if($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            $form->bind(new CommentEntity());

            if($form->isValid()) {

                // Use post manager service to add new comment to post.
                $this->postManager->addCommentToPost($post, $form->getData());

                // Redirect the user again to "view" page.
                return $this->redirect()->toRoute('blog/post', ['id' => $id]);
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
