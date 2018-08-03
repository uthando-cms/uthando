<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Repository
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\Repository;


use Blog\Entity\PostEntity;
use Blog\Entity\TagEntity;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * @param $tag
     * @return mixed
     */
    public function findPostsByTagName($tag)
    {
        $entityManager  = $this->getEntityManager();
        $queryBuilder   = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(PostEntity::class, 'p')
            ->join('p.tags', 't')
            ->where('p.status = ?1')
            ->andWhere('t.seo = ?2')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', PostEntity::STATUS_PUBLISHED)
            ->setParameter('2', $tag);

        $posts = $queryBuilder
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true, 300, 'post-tags')
            ->getResult();

        return $posts;
    }

    /**
     * Optimised call for tag cloud.
     *
     * @return mixed
     */
    public function fetchTagCount()
    {
        $entityManager  = $this->getEntityManager();
        $queryBuilder   = $entityManager->createQueryBuilder();

        $queryBuilder->select('t.name, t.seo, COUNT(t) AS count')
            ->from(TagEntity::class, 't')
            ->join('t.posts', 'p')
            ->groupBy('t.name, t.seo')
            ->orderBy('t.name', 'ASC')
            ->where('p.status =?1')
            ->setParameter('1', PostEntity::STATUS_PUBLISHED);

        $posts = $queryBuilder
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true, 300, 'post-tags')
            ->getResult();

        return $posts;
    }
}