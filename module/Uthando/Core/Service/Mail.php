<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Service;

use DOMElement;
use Zend\Mail\Header\ContentType;
use Zend\Mail\Message;
use Zend\Mail\Transport;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\Stdlib\Exception\DomainException;
use Zend\View\Model\ViewModel;
use Uthando\Core\Options\OptionsTrait;
use Zend\Mail\Transport\TransportInterface;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\View\Renderer\RendererInterface;
use Zend\Mail\Address;
use Zend\Mime\Mime;

/**
 * Class Mail
 *
 * @package UUthando\Core\Service
 */
class Mail
{
    use OptionsTrait;
    
    /**
     * @var \Zend\View\Renderer\RendererInterface
     */
    protected $view;
    
    /**
     * @var array
     */
    protected $transport = [];
    
    /**
     * @var \Zend\View\Model\ViewModel
     */
    protected $layout;

    /**
     * @var array
     */
    protected $attachments = [];

    /**
     * @param RendererInterface $view
     * @param $options
     */
    public function __construct(RendererInterface $view, $options)
    {
        $this->setOptions($options);
        $this->setView($view);
        
        $this->setLayout();
    }

    /**
     * @param null $layout
     * @return $this
     */
    public function setLayout($layout = null)
    {
    	if (null !== $layout && !is_string($layout) && !($layout instanceof ViewModel)) {
    		throw new InvalidArgumentException(
				'Invalid value supplied for setLayout.'.
				'Expected null, string, or Zend\View\Model\ViewModel.'
    		);
    	}
    	
    	if (null === $layout && $this->hasOption('layout')) {
    		return $this;
    	}
    	
    	if (null === $layout) {
    		$layout = (string) $this->getOption('layout');
    	}
    	
    	if (is_string($layout)) {
    		$template = $layout;
    		$layout = new ViewModel;
    		$layout->setTemplate($template);
    	}
    	
    	$this->layout = $layout;
    	
    	return $this;
    }

    /**
     * @return ViewModel
     */
    public function getLayout()
    {
    	return $this->layout;
    }

    /**
     * @param $body
     * @param null $mimeType
     * @return array
     */
    public function getMessageBody($body, $mimeType = null)
    {
        // Make sure we have a string.
        if ($body instanceof ViewModel) {
        	$body = $this->getView()->render($body);
        	$detectedMimeType = Mime::TYPE_HTML;
        } elseif (null === $body) {
        	$detectedMimeType = Mime::TYPE_TEXT;
        	$body = '';
        }
        
        if (null !== ($layout = $this->getLayout())) {
        	$layout->setVariables(array(
        		'content' => $body,
        	));
        	
        	$detectedMimeType = Mime::TYPE_HTML;
        	$body = $this->parseTemplate($layout);
        }
        
        if (null === $mimeType && !isset($detectedMimeType)) {
        	$mimeType = preg_match("/<[^<]+>/", $body) ? Mime::TYPE_HTML : Mime::TYPE_TEXT;
        } elseif (null === $mimeType) {
        	$mimeType = $detectedMimeType;
        }
        
        $htmlPart = new MimePart($body);
        $htmlPart->type = $mimeType;
        $htmlPart->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
        
        if (null !== ($charset = $this->getOption('charset'))) {
        	$htmlPart->charset = $charset;
        }
        
        if ($mimeType === Mime::TYPE_HTML) {
        	$text = $this->renderTextBody($body);
        	$textPart = new MimePart($text);
        	$textPart->type = Mime::TYPE_TEXT;
            $textPart->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
        	
        	if ($this->getOption('charset')) {
        		$textPart->charset = $this->getOption('charset');
        	}
        }

        $bodyMessage = new MimeMessage();
        
        if (count($this->attachments) > 0) {
            $content = new MimeMessage();

            if (isset($textPart)) {
                $content->addPart($textPart);
            }

            if (isset($content)) {
                $content->addPart($htmlPart);
            }

            $contentPart = new MimePart($content->generateMessage());
            $contentPart->type = 'multipart/alternative; boundary="' . $content->getMime()->boundary() . '"';

            $bodyMessage->addPart($contentPart);
            $messageType = Mime::MULTIPART_RELATED;

            foreach ($this->attachments as $attachment) {
                $bodyMessage->addPart($attachment);
            }
        } else {
            if (isset($textPart)) {
                $bodyMessage->addPart($textPart);
            }

            if (isset($htmlPart)) {
                $bodyMessage->addPart($htmlPart);
            }

            $messageType = Mime::MULTIPART_ALTERNATIVE;
        }


        
        return ['body' => $bodyMessage, 'type' => $messageType];
    }

    /**
     * @param $filename
     * @return string
     */
    public function mimeByExtension($filename)
    {
        $type = '';

        if (is_readable($filename) ) {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            switch ($extension) {
                case 'gif':
                    $type = 'image/gif';
                    break;
                case 'jpg':
                case 'jpeg':
                    $type = 'image/jpg';
                    break;
                case 'png':
                    $type = 'image/png';
                    break;
                default:
                    $type = 'application/octet-stream';
            }
        }
    
        return $type;
    }

    /**
     * @param null $body
     * @param null $mimeType
     * @return Message
     */
    public function compose($body = null, $mimeType = null)
    {
    	// Supported types are null, ViewModel and string.
    	if (null !== $body && !is_string($body) && !($body instanceof ViewModel)) {
    		throw new InvalidArgumentException(
    			'Invalid value supplied. Expected null, string or instance of Zend\View\Model\ViewModel.'
    		);
    	}
    	
    	$bodyParts = $this->getMessageBody($body, $mimeType);
    	$message = new Message;
    	$message->setBody($bodyParts['body']);
        /* @var ContentType $contentType */
        $contentType = $message->getHeaders()->get('content-type');
        $contentType->setType($bodyParts['type']);
        $message->setEncoding('UTF-8');
    	
    	return $message;
    }

    /**
     * @param Message $message
     * @param null $transport
     * @return mixed
     */
    public function send(Message $message, $transport = null)
    {
		if (!$message->getSender()) {
			$sender       = ($transport) ? $transport : 'default';
			$emailAddress = $this->getOption('addresses')[$sender];

			$message->setSender($emailAddress['address'], $emailAddress['name']);
		}
        
        return $this->getMailTransport($transport)
            ->send($message);
    }

    /**
     * @param $stringOrView
     * @return mixed|string
     */
    public function parseTemplate($stringOrView)
    {
        if ($stringOrView instanceof ViewModel) {
            $stringOrView = $this->getView()->render($stringOrView);
        }
        
        // find inline images.
        $xml = new \DOMDocument();
        $xml->loadHTML($stringOrView);
        
        $images = $xml->getElementsByTagName('img');
        $attachments = [];

        /* @var DomElement $image */
        foreach ($images as $image) {
            $file = $image->getAttribute('src');

            $binary = file_get_contents($file);
            $mime = $this->mimeByExtension($file);

            $fileName = pathinfo($file, PATHINFO_BASENAME);

            $attachment = new MimePart($binary);
            $attachment->setType($mime);
            $attachment->setDisposition(Mime::DISPOSITION_ATTACHMENT);
            $attachment->setEncoding(Mime::ENCODING_BASE64);

            $attachment->setFileName($fileName);
            $attachment->setId('cid_' . md5($fileName));

            $stringOrView = str_replace($file, 'cid:' . $attachment->getId(), $stringOrView);

            $attachments[] = $attachment;
        }

        $this->attachments = $attachments;
        
        return $stringOrView;
    }

    /**
     * @param $body
     * @return string
     */
    public function renderTextBody($body)
    {
    	$body = html_entity_decode(
    		trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/s', '', $body))), ENT_QUOTES
    	);
    	 
    	if (empty($body)) {
    		$body = 'To view this email, open it an email client that supports HTML.';
    	}
    	 
    	return $body;
    }

    /**
     * @param $email
     * @param null $name
     * @return Address
     */
    public function createAddress($email, $name = null)
    {
    	return new Address($email, $name);
    }

    /**
     * @param null $config
     * @return mixed
     */
    public function getMailTransport($config = null)
    {
        $config = ($config) ? (string) $config : 'default';
        
        if (array_key_exists($config, $this->transport)) {
        	return $this->transport[$config];
        }
        
        $transportConfig  = $this->getOption('transport')[$config];
        $class            = $transportConfig['class'];
        $options          = $transportConfig['options'];
        
        switch ($class) {
        	case Transport\Sendmail::class:
        	case 'Sendmail':
        	case 'sendmail';
        	   $transport = new Transport\Sendmail();
        	   break;
        	case Transport\Smtp::class;
        	case 'Smtp';
        	case 'smtp';
        	   $options = new Transport\SmtpOptions($options);
        	   $transport = new Transport\Smtp($options);
        	   break;
        	case Transport\File::class;
        	case 'File';
        	case 'file';
        	   $options = new Transport\FileOptions($options);
        	   $transport = new Transport\File($options);
        	   break;
        	default:
        		throw new DomainException(sprintf(
                    'Unknown mail transport type provided ("%s")',
                    $class
        		));
        }
        
        $this->transport[$config] = $transport;
        
        return $this->transport[$config];
    }

    /**
     * @param TransportInterface $transport
     * @param string $config
     */
    public function setTransport(TransportInterface $transport, $config = 'default')
    {
        $this->transport[$config] = $transport;
    }
    
	/**
	 * @return \Zend\View\Renderer\RendererInterface $view
	 */
	public function getView()
	{
		return $this->view;
	}

	/**
	 * @param \Zend\View\Renderer\RendererInterface $view
	 * @return $this
	 */
	public function setView($view)
	{
		$this->view = $view;
		return $this;
	}
}
