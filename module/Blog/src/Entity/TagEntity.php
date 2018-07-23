<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Blog\Entity
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/17
 * @license   see LICENSE
 */

namespace Blog\Entity;

class TagEntity
{
    protected $id;

    protected $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): TagEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): TagEntity
    {
        $this->name = $name;
        return $this;
    }
}
