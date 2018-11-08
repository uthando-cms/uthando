<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.md
 */

declare(strict_types=1);

namespace Uthando\Core\Controller;


use Zend\Captcha\Exception\ImageNotLoadableException;
use Zend\Http\PHPEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class CaptchaController
 *
 * @package Uthando\Core\Controller
 * @method Response getResponse()
 */
class CaptchaController extends AbstractActionController
{
    /**
     * @var array
     */
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return Response
     */
    public function generateAction(): Response
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', "image/png");

        $id = $this->params('id', false);

        if ($id) {
            $config = $this->options;

            $image = join('/', [
                $config['options']['imgDir'],
                $id
            ]);

            if (file_exists($image) !== false) {

                $imageRead = file_get_contents($image);

                $response->setStatusCode(200);
                $response->setContent($imageRead);

                if (true === file_exists($image) && is_file($image)) {
                    unlink($image);
                }
            } else {
                throw new ImageNotLoadableException(sprintf('Could not load CAPTCHA image %s', $image));
            }

        }

        return $response;
    }
}
