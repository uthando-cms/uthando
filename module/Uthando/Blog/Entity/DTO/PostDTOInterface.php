<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Blog\Entity\DTO
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Blog\Entity\DTO;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PostDTOInterface
 * @package Uthando\Blog\Entity\DTO
 * @property bool $status
 * @property string $title
 * @property string $seo
 * @property string $content
 * @property ArrayCollection $tags
 * @property string $newTags
 */
interface PostDTOInterface
{

}