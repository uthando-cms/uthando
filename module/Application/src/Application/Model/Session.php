<?php
namespace Application\Model;

class Session implements ModelInterface
{
    use Model;
    
	/**
     * ID Column
     * @var string
     */
    protected  $id;

    /**
     * Name Column
     * @var string
     */
    protected  $name;

    /**
     * Data Column
     * @var string
     */
    protected  $data;

    /**
     * Lifetime Column
     * @var int
     */
    protected  $lifetime;

    /**
     * Modified Column
     * @var int
     */
    protected  $modified;

	/**
	 * @return the int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = (string) $id;
		return $this;
	}
	
	/**
	 * @return the string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = (string) $name;
		return $this;
	}
	
	/**
	 * @return the string
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/**
	 * @param string $data
	 */
	public function setData($data)
	{
		$this->data = (string) $data;
		return $this;
	}
	
	/**
	 * @return the int
	 */
	public function getLifetime()
	{
		return $this->lifetime;
	}
	
	/**
	 * @param int $lifetime
	 */
	public function setLifetime($lifetime)
	{
		$this->lifetime = (int) $lifetime;
		return $this;
	}
	
	/**
	 * @return the int
	 */
	public function getModified()
	{
		return $this->modified;
	}
	
	/**
	 * @param int $modified
	 */
	public function setModified($modified)
	{
		$this->modified = (int) $modified;
		return $this;
	}	
}
