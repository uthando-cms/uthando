<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Core\Db\Schema
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      22/07/18
 * @license   see LICENSE
 */

namespace Core\Db\Schema;


use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Ddl\SqlInterface;

interface TableInterface
{
    /**
     * @param SqlInterface $ddl
     * @return ResultInterface
     */
    public function query(SqlInterface $ddl): ResultInterface;

    /**
     * Create table definition
     */
    public function create(): SqlInterface;

    /**
     * Alter table definition
     */
    public function alter(): SqlInterface;

    /**
     * Drop table definition
     */
    public function drop(): SqlInterface;
}
