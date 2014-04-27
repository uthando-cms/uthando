<?php

namespace Application\Service;

class SessionManager extends AbstractService
{	
    protected $mapperClass = 'Application\Mapper\Session';
    protected $form = '';
    protected $inputFilter = '';
    
    public function getById($id)
    {
        $id = (string) $id;
        return $this->getMapper()->getById($id);
    }
}
