<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\Form\Element;

use Uthando\Core\Form\Element\Captcha;
use UthandoTest\Framework\HttpControllerTestCase;
use Zend\View\Helper\Url;

class CaptchaTest extends HttpControllerTestCase
{
    public function testCanGetFromFormManager()
    {
        $form = $this->getApplication()
            ->getServiceManager()
            ->get('FormElementManager')
            ->get(Captcha::class);

        $this->assertInstanceOf(Captcha::class, $form);
    }

    public function testCanGetFromFormMangerViaAliases()
    {
        $form = $this->getApplication()
            ->getServiceManager()
            ->get('FormElementManager')
            ->get('corecaptcha');
        $this->assertInstanceOf(Captcha::class, $form);

        $form = $this->getApplication()
            ->getServiceManager()
            ->get('FormElementManager')
            ->get('CoreCaptcha');
        $this->assertInstanceOf(Captcha::class, $form);
    }

    public function testWillSetFont()
    {
        $urlHelper = $this->getApplication()
            ->getServiceManager()
            ->get('ViewHelperManager')
            ->get('url');

        $options = [
            'url_helper' => $urlHelper,
            'config' => [
                'class' => 'Image',
                'options' => [
                    'imgDir' => './data/captcha',
                    'fontDir' => './data/fonts',
                    'font' => 'arial.ttf',
                    'imgAlt' => 'CAPTCHA Image',
                    'suffix' => '.png',
                    'fsize' => 24,
                    'width' => 350,
                    'height' => 100,
                    'expiration' => 600,
                    'dotNoiseLevel' => 40,
                    'lineNoiseLevel' => 3
                ],
            ],
        ];

        $form = new Captcha('captcha', $options);
        $form->init();

        $font = $form->getCaptcha()->getFont();

        $this->assertSame(
                str_replace('./data/fonts/', '', $font),
                $options['config']['options']['font']
        );
    }
}
