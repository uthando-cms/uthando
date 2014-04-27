<?php
namespace Application\Filter;

use Zend\Filter\AbstractFilter;

class Ucwords extends AbstractFilter
{

    public function filter($value)
    {
    	return ucwords($value);
    }
}
