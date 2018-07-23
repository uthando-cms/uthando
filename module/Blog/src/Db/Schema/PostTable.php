<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   Blog\Db\Schema
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      19/07/18
 * @license   see LICENSE
 */

namespace Blog\Db\Schema;


use Core\Db\Schema\AbstractTable;
use Zend\Db\Sql\Ddl\Column\Boolean;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Column\Text;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;
use Zend\Db\Sql\Ddl\Constraint\UniqueKey;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Ddl\DropTable;
use Zend\Db\Sql\Ddl\SqlInterface;

class PostTable extends AbstractTable
{
    /**
     * @return CreateTable
     */
    public function create(): SqlInterface
    {
        $ddl = new CreateTable('blog');

        $ddl->addColumn(new Integer('id', false, null, [
            'unsigned' => true,
            'autoincrement' => true,
        ]));
        $ddl->addConstraint(new PrimaryKey('id'));

        $ddl->addColumn(new Varchar('title', 255, false, null));

        $ddl->addColumn(new Varchar('seo', 255, false, null));
        $ddl->addConstraint(new UniqueKey('seo', 'seo'));

        $ddl->addColumn(new Text('content', null, true, null));

        $ddl->addColumn(new Boolean('status', false, 0));

        // DATE_W3C
        $ddl->addColumn(new Varchar('date_created', 25, false, null));

        $ddl->addColumn(new Varchar('date_modified', 25, false, null));

        return $ddl;
    }

    /**
     * @return DropTable
     */
    public function drop(): SqlInterface
    {
        $ddl = new DropTable('blog');

        return $ddl;
    }

    /**
     * Alter table definition
     */
    public function alter(): SqlInterface
    {
        // TODO: Implement alter() method.
    }
}
