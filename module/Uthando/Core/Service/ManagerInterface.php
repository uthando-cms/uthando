<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Service;


use Uthando\Core\Entity\DtoInterface;
use Uthando\Core\Entity\EntityInterface;

interface ManagerInterface
{
    /**
     * @param DtoInterface $dto
     */
    public function add(DtoInterface $dto): void;

    /**
     * @param EntityInterface $entity
     * @param DtoInterface $dto
     */
    public function update(EntityInterface $entity, DtoInterface $dto): void;

    /**
     * @param EntityInterface $entity
     */
    public function delete(EntityInterface $entity): void;
}