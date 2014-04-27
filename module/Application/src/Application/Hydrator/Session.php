<?php
namespace Application\Hydrator;

class Session extends AbstractHydrator
{
	/**
	 * @param \Application\Model\Session
	 * @return array
	 */
	public function extract($object)
	{
		return array(
			'id'		=> $object->getId(),
			'modified'	=> $object->getModified(),
			'lifetime'	=> $object->getLifetime(),
			'name'		=> $object->getName(),
			'data'		=> $object->getData()
		);
	}
}
