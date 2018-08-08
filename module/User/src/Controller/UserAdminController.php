<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   User\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace User\Controller;


use Doctrine\ORM\EntityRepository;
use User\Service\UserManager;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

final class UserAdminController extends AbstractActionController
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var EntityRepository
     */
    protected $userRepository;

    /**
     * @var Form
     */
    protected $form;

    public function __construct(EntityRepository $entityRepository, UserManager $userManager, Form $form)
    {
        $this->form             = $form;
        $this->userRepository   = $entityRepository;
        $this->userManager      = $userManager;
    }

    public function indexAction()
    {
        $page   = $this->params()->fromRoute('page', 1);

        // Get recent posts
        $posts = $this->userRepository
            ->findBy([], ['dateCreated'=>'DESC']);

        $adaptor    = new ArrayAdapter($posts);
        $paginator  = new Paginator($adaptor);

        $paginator->setDefaultItemCountPerPage(25);
        $paginator->setCurrentPageNumber($page);

        // Render the view template
        return new ViewModel([
            'users' => $paginator,
        ]);
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}