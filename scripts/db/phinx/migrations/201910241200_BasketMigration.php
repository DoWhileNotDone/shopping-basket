<?php

use Phinx\Migration\AbstractMigration;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class BasketMigration extends AbstractMigration
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
        $table = $this->table("{$schema}.baskets", ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn("id", "uuid", ["null" => false])
            ->addColumn("total", "decimal", ["precision" => 15, "scale" => 2, "default" => 0])
            ->addTimestamps()
            ->addIndex(["id"], ["unique" => true, "name" => "baskets_id_idx"]);
        $table->create();
    }
}
