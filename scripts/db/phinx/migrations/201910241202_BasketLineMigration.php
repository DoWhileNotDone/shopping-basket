<?php

use Phinx\Migration\AbstractMigration;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class BasketLineMigration extends AbstractMigration
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
        $table = $this->table("{$schema}.basket_lines", ['id' => false]);
        $table
            ->addColumn("basket_id", "uuid", [ "null" => false])
            ->addColumn("item_id", "uuid", [ "null" => false])
            ->addColumn("quantity", "integer", ["null" => false])
            ->addIndex(["basket_id", "item_id"], ["unique" => true, "name" => "basket_lines_unique_idx"]);
        $table->create();
    }
}
