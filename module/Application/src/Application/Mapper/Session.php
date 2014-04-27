<?php
namespace Application\Mapper;

class Session extends AbstractMapper
{
	protected $table = 'session';
	protected $primary = 'id';
	protected $model = 'Application\Model\Session';
	protected $hydrator = 'Application\Hydrator\Session';
	
}
