<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Core\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Core\Controller;

use Uthando\Core\Controller\CaptchaController;
use UthandoTest\Framework\HttpControllerTestCase;
use Zend\Captcha\Image;

class CaptchaControllerTest extends HttpControllerTestCase
{
    public function testGenerateActionCanBeAccessed()
    {
        $this->dispatch('/captcha');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Uthando');
        $this->assertControllerName(CaptchaController::class);
        $this->assertControllerClass('CaptchaController');
        $this->assertMatchedRouteName('captcha-form-generate');
    }

    /**
     * @throws \Exception
     */
    public function testThrowsExceptionWithInvalidId()
    {
        $this->dispatch('/captcha/7416480ad78c8c72a87aad39a33dc215.png');
        $this->assertResponseStatusCode(500);
    }

    public function testCanDisplayImage()
    {
        ini_set('memory_limit', '256M');
        $config = $this->getApplication()->getServiceManager()->get('config');
        $options = $config['uthando']['captcha']['options'];
        //var_dump($options);

        $font =  $options['fontDir'] . '/' . $options['font'];
        $captcha = new Image($options);
        $captcha->setFont($font);

        $img = $captcha->generate();

        $this->dispatch('/captcha/' . $img . '.png');
        $this->assertResponseStatusCode(200);
        $this->assertFileNotExists('./data/captcha/' . $img . '.png');
    }
}
