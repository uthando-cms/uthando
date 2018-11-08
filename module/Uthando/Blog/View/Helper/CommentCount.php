<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Blog\View\Helper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Blog\View\Helper;


use Uthando\Blog\Entity\PostEntity;
use Zend\View\Helper\AbstractHelper;

class CommentCount extends AbstractHelper
{
    public function __invoke(PostEntity $post)
    {
       $commentCount = $post->getComments()->count();

        switch ($commentCount) {
            case 0:
                $str = 'No comments';
                break;
            case 1:
                $str = '1 comment';
                break;
            default:
                $str = $commentCount . ' comments';
        }

        return $str;
    }
}