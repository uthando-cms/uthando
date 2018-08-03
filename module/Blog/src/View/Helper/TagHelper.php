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


use Zend\Tag\Cloud;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class TagHelper
 *
 * @package Blog\View\Helper
 * @method PhpRenderer getView()
 */
class TagHelper extends AbstractHelper
{
    //private $route;

    /*private function createTagLink($tag): string
    {
        $view = $this->getView();

        return  '<a href="' . $view->url($this->route, [
                'tag' => $view->escapeHtml($tag->seo),
            ]) . '">' . $view->escapeHtml($tag->name) . '</a>';
    }*/

    public function renderTags($tags)
    {
       $html = '';

       foreach ($tags as $tag) {
           $html .= $this->getView()
                   ->escapeHtml($tag->name) . ', ';
       }

       return rtrim($html, ', ');
    }

    /**
     * @param $tags
     * @param $route
     * @return Cloud
     */
    public function renderTagCloud($tags, $route)
    {
        $view = $this->getView();

        $tagArray = [
            'cloudDecorator' => [
                'decorator' => 'htmlCloud',
                'options'   => [
                    'htmlTags' => [
                        'ul' => ['class' => 'list-inline'],
                    ],
                    'separator' => '&nbsp;',
                ],
            ],
            'tagDecorator' => [
                'decorator' => 'htmlTag',
                'options'   => [
                    'minFontSize' => '12',
                    'maxFontSize' => '30',
                    'htmlTags'    => [
                        'li' => ['class' => ''],
                    ],
                ],
            ],
        ];

        foreach ($tags as $tag) {
            $tagArray['tags'][] = [
                'title' => $view->escapeHtml($tag['name']),
                'weight' => $view->escapeHtml($tag['count']),
                'params' => [
                    'url' => $view->url($route, [
                        'tag' => $view->escapeHtml($tag['seo']),
                    ]),
                    'title' => $view->escapeHtml($tag['count']) . ' topic',
                ],
            ];
        }

        $tagCloud = new Cloud($tagArray);

        return $tagCloud;
    }
}