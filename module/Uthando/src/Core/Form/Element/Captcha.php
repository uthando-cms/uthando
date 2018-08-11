<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\UthandoCommon\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Uthando\Core\Form\Element;

use Zend\Form\Element\Captcha as ZendCaptcha;


/**
 * Class Captcha
 *
 * @package Uthando\Core\Form\Element
 */
final class Captcha extends ZendCaptcha
{
    /**
     * Set up elements
     */
    public function init()
    {
        $spec = $this->getOption('config');

        if ('Image' === $spec['class']) {

            $font = $spec['options']['font'];

            if (is_array($font)) {
                $rand = array_rand($font);
                $randFont = $font[$rand];
                $font = $randFont;
            }

            $spec['options']['font'] = join('/', [
                $spec['options']['fontDir'],
                $font
            ]);

            $spec['options']['imgUrl'] = $this->getOption('url_helper')('captcha-form-generate');
        }

        $this->setCaptcha($spec);
    }
}
