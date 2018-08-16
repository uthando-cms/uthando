<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Blog\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Blog\Service;


use Uthando\Blog\Entity\CommentEntity;
use Uthando\Blog\Entity\DTO\AddComment;
use Uthando\Blog\Entity\DTO\AddPost;
use Uthando\Blog\Entity\DTO\EditPost;
use Uthando\Blog\Entity\DTO\PostDTOInterface;
use Uthando\Blog\Entity\PostEntity;
use Uthando\Blog\Entity\TagEntity;
use Uthando\Core\Filter\Seo;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
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
     * @param AddPost $dto
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function addPost(AddPost $dto): void
    {
        $post       = new PostEntity();
        $hydrator   = new DoctrineObject($this->entityManager, false);
        /** @var PostEntity $post */
        $post       = $hydrator->hydrate($dto->getArrayCopy(), $post);

        // Add the entity to entity manager.
        $this->entityManager->persist($post);
        $this->processNewTags($post, $dto);

        // Apply changes to database.
        $this->entityManager->flush();
        $this->clearCache();
    }

    /**
     * @param PostEntity $post
     * @param EditPost $dto
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function updatePost(PostEntity $post, EditPost $dto): void
    {
        $hydrator = new DoctrineObject($this->entityManager, false);

        $post->updateDates($dto->status);
        $hydrator->hydrate($dto->getArrayCopy(), $post);

        $this->processNewTags($post, $dto);

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
     * @param PostDTOInterface $dto
     * @throws \Exception
     */
    private function processNewTags(PostEntity $post, PostDTOInterface $dto): void
    {
        $newTags    = explode(',', $dto->newTags);
        $tags       = [];

        $tagEntity = $this->entityManager->getRepository(TagEntity::class);

        foreach ($newTags as $newTag) {
            $newTag = trim($newTag);
            if ('' === $newTag) continue;
            $seo = StaticFilter::execute($newTag, Seo::class);

            $match = $tagEntity->findOneBy(['seo' => $seo]);

            if ($match instanceof TagEntity) {
                if (!$post->getTags()->contains($match)) {
                    $tags[] = $match;
                }
            } else {
                $tags[] = new TagEntity($newTag, $seo);
            }
        }

        $post->addTags($tags);
    }

    // This method adds a new comment to post-admin.

    /**
     * @param PostEntity $post
     * @param AddComment $dto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function addCommentToPost(PostEntity $post, AddComment $dto)
    {
        // Add post to comment
        $dto->post  = $post;
        $comment    = new CommentEntity();
        $hydrator   = new DoctrineObject($this->entityManager, false);
        $comment    = $hydrator->hydrate($dto->getArrayCopy(), $comment);

        $post->getComments()->add($comment);

        // Apply changes.
        $this->entityManager->flush();
    }
}