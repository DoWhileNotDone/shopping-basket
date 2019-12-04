<?php

use Phinx\Migration\AbstractMigration;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class ItemMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTables
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $schema = $_ENV['DB_SCHEMA'];
        $table = $this->table("{$schema}.items", ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn("id", "uuid", ["null" => false])
            ->addColumn("name", "string", ["limit" => 255, "null" => false])
            ->addColumn("price", "decimal", ["precision" => 5, "scale" => 2])
            ->addTimestamps()
            ->addIndex(["id"], ["unique" => true, "name" => "items_id_idx"])
            ->addIndex(["name"], ["unique" => true, "name" => "items_name_idx"]);
        $table->create();
    }
}
