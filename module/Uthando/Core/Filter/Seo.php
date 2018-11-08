<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Filter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

declare(strict_types=1);

namespace Uthando\Core\Filter;

use Zend\Filter\AbstractFilter;

/**
 * Class Seo
 *
 * @package Core\Filter
 */
final class Seo extends AbstractFilter
{
    /**
     * @param mixed $value
     * @param null $context
     * @return string
     */
    public function filter($value)
    {
        $find = ['`', '&', ' ', '"', "'", '+'];
        $replace = ['', 'and', '-', '', '', '-',];
        $new = str_replace($find, $replace, $value);

        $noalpha = 'ÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÀÈÌÒÙàèìòùÄËÏÖÜäëïöüÿÃãÕõÅåÑñÇç@°ºª';
        $alpha = 'AEIOUYaeiouyAEIOUaeiouAEIOUaeiouAEIOUaeiouyAaOoAaNnCcaooa';

        $new = substr($new, 0, 255);
        $new = strtr($new, $noalpha, $alpha);

        // not permitted chars are replaced with "-"
        $new = preg_replace('/[^a-zA-Z0-9_\+]/', '-', $new);

        //remove -----'s
        $new = preg_replace('/(-+)/', '-', $new);

        return strtolower(rtrim($new, '-'));
    }

}
