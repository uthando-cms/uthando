<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class MailOptions
 *
 * @package Uthando\Core\Options
 */
class MailOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $transport;

    /**
     * @var array
     */
    protected $addresses;

    /**
     * @var bool
     */
    protected $generateAlternativeBody;

    /**
     * @var string
     */
    protected $layout;

    /**
     * @var string
     */
    protected $charset;

    /**
     * @var int
     */
    protected $maxAmountToSend;

    /**
     * @return array
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param $transport
     * @return $this
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param $addresses
     * @return $this
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return bool
     */
    public function getGenerateAlternativeBody()
    {
        return $this->generateAlternativeBody;
    }

    /**
     * @param $generateAlternativeBody
     * @return $this
     */
    public function setGenerateAlternativeBody($generateAlternativeBody)
    {
        $this->generateAlternativeBody = $generateAlternativeBody;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param $charset
     * @return $this
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxAmountToSend()
    {
        return $this->maxAmountToSend;
    }

    /**
     * @param $maxAmountToSend
     * @return $this
     */
    public function setMaxAmountToSend($maxAmountToSend)
    {
        $this->maxAmountToSend = (int)$maxAmountToSend;
        return $this;
    }
}
