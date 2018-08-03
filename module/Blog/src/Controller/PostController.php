<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\Controller;


use Blog\Entity\PostEntity;
use Blog\Repository\PostRepository;
use Blog\Service\PostManager;
use Ramsey\Uuid\Uuid;
use Zend\Form\Form;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

/**
 * Class PostController
 * @package Blog\Controller
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
     * @var Form
     */
    private $form;

    public function __construct(PostRepository $postRepository, PostManager $postManager, Form $form)
    {
        $this->postRepository   = $postRepository;
        $this->postManager      = $postManager;
        $this->form             = $form;
    }

    public function indexAction()
    {
        $page   = $this->params()->fromRoute('page', 1);

        // Get recent posts
        $posts = $this->postRepository
            ->findBy([], ['dateCreated'=>'DESC']);

        $adaptor    = new ArrayAdapter($posts);
        $paginator  = new Paginator($adaptor);

        $paginator->setDefaultItemCountPerPage(25);
        $paginator->setCurrentPageNumber($page);

        // Render the view template
        return new ViewModel([
            'posts' => $paginator,
            'postManager' => $this->postManager
        ]);
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function addAction()
    {
        // Create the form.
        $form = $this->form;

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            $form->bind(new PostEntity());

            if ($form->isValid()) {

                // Use post manager service to add new post to database.
                $this->postManager->addPost($form->getData());

                // Redirect the user to "index" page.
                return $this->redirect()->toRoute('admin/post');
            }
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!Uuid::isValid($id)) {
            throw new \Exception(sprintf('Not a valid UUID: %s', $id));
        }

        /** @var PostEntity $post */
        $post = $this->postRepository->findOneBy(['id' => $id]);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $postOld = $post->getArrayCopy();

        $form = $this->form;
        $form->bind($post);

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {
            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);

            if ($form->isValid()) {

                // Use post manager service to add new post to database.
                $this->postManager->updatePost($form->getData(), $postOld);

                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('admin/post');
            }
        } else {
            $form->setData($post->getArrayCopy());
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'post' => $post
        ]);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        if (!Uuid::isValid($id)) {
            throw new \Exception(sprintf('Not a valid UUID: %s', $id));
        }

        /** @var PostEntity $post */
        $post = $this->postRepository->findOneBy(['id' => $id]);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $this->postManager->removePost($post);

        // Redirect the user to "index" page.
        return $this->redirect()->toRoute('admin/post');
    }
}