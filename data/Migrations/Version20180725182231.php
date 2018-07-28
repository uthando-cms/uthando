<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180725182231 extends AbstractMigration
{
    /**
     * Returns the description of this migration.
     */
    public function getDescription()
    {
        $description = 'This is the initial migration which creates uthando cms tables.';
        return $description;
    }

    public function up(Schema $schema) : void
    {
        // Create 'posts' table
        $table = $schema->createTable('posts');
        $table->addColumn('id',  'uuid', ['length'=>32, 'notnull'=>true]);
        $table->addColumn('title', 'string', ['notnull'=>true]);
        $table->addColumn('seo', 'string', ['notnull'=>true, 'unique'=>true]);
        $table->addColumn('content', 'text', ['notnull'=>false]);
        $table->addColumn('status', 'boolean', ['notnull'=>true, 'default'=>0]);
        $table->addColumn('date_created', 'string', ['notnull'=>true, 'length'=>25]);
        $table->addColumn('date_modified', 'string', ['notnull'=>true, 'length'=>25]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['seo']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('posts');
    }
}
