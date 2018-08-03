<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Blog\View\Helper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Blog\View\Helper;


use Blog\Entity\PostEntity;
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