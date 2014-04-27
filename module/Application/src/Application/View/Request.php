<?php

namespace Application\View;

use Application\View\AbstractViewHelper;
 
class Request extends AbstractViewHelper
{
    protected $serviceLocator;
 
    public function __invoke()
    {
        return $this->getServiceLocator()
			->getServiceLocator()
			->get('Request');
    }
}