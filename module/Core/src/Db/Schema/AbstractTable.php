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


use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Ddl\SqlInterface;
use Zend\Db\Sql\Sql;

abstract class AbstractTable implements TableInterface
{
    /**
     * @var Adapter
     */
    protected $dbAdapter;

    /**
     * Constructor
     * @param AdapterInterface $dbAdapter
     */
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Do database query.
     *
     * @param SqlInterface $ddl
     * @return \Zend\Db\Adapter\Driver\StatementInterface|\Zend\Db\ResultSet\ResultSet
     */
    public function query(SqlInterface $ddl): ResultInterface
    {
        $sql = new Sql($this->dbAdapter);

        $result = $this->dbAdapter->query(
           $sql->buildSqlString($ddl),
            Adapter::QUERY_MODE_EXECUTE
        );

        return $result;
    }
}
