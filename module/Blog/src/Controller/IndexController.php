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


use Blog\Entity\PostEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * @package Blog\Controller
 */
final class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager;
     */
    protected $entityManager;

    /**
     * IndexController constructor.
     * @param $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * @return ViewModel
     * @throws \Exception
     */
    public function indexAction() : ViewModel
    {
        /** @var PostEntity $post */
        $posts = $this->entityManager->getRepository(PostEntity::class)->findBy(
            ['status' => PostEntity::STATUS_PUBLISHED]
        );

        return new ViewModel([
            'post' => $posts,
        ]);
    }
}
