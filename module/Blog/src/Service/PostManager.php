<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\Service;


use Blog\Entity\CommentEntity;
use Blog\Entity\PostEntity;
use Blog\Entity\TagEntity;
use Core\Filter\Slug;
use Doctrine\ORM\EntityManager;
use Zend\Filter\StaticFilter;

final class PostManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * PostManager constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Clears the cache
     *
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    private function clearCache()
    {
        $this->entityManager->clear();
        $cacheDriver = $this->entityManager->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('post-tags');
    }

    /**
     * @param PostEntity $post
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function addPost(PostEntity $post): void
    {
        // Add the entity to entity manager.
        $this->entityManager->persist($post);
        $this->processNewTags($post);

        // Apply changes to database.
        $this->entityManager->flush();
        $this->clearCache();
    }

    /**
     * @param PostEntity $post
     * @param array $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function updatePost(PostEntity $post, array $data): void
    {
        $post->updateDates($data);

        $this->processNewTags($post);

        // Apply changes to database.
        $this->entityManager->flush();
        $this->clearCache();
    }

    /**
     * @param PostEntity $post
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    public function removePost(PostEntity $post): void
    {
        // Remove associated comments
        foreach ($post->getComments() as $comment) {
            $this->entityManager->remove($comment);
        }

        $post->removeTags($post->getTags());

        $this->entityManager->remove($post);

        $this->entityManager->flush();
        $this->clearCache();
    }

    /**
     * @param PostEntity $post
     * @throws \Exception
     */
    private function processNewTags(PostEntity $post): void
    {
        $newTags    = explode(',', $post->newTags);
        $tags       = [];

        foreach ($newTags as $newTag) {
            $newTag = trim($newTag);
            if ('' === $newTag) continue;
            $seo = StaticFilter::execute($newTag, Slug::class);
            $tags[] = new TagEntity($newTag, $seo);
        }

        $post->addTags($tags);
    }

    // This method adds a new comment to post.

    /**
     * @param PostEntity $post
     * @param CommentEntity $comment
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addCommentToPost(PostEntity $post, CommentEntity $comment)
    {
        // Add post to comment.
        $comment->post = $post;
        // Add comment to post.
        $post->comments->add($comment);

        // Apply changes.
        $this->entityManager->flush();
    }
}