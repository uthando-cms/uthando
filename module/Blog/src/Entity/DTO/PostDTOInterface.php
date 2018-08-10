<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\Entity\DTO
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\Entity\DTO;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PostDTOInterface
 * @package Blog\Entity\DTO
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