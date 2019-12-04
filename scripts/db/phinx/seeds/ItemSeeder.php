<?php

use Phinx\Seed\AbstractSeed;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class ItemSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'id' => '2b68ecfe-b00f-4574-9f0d-4a87f6e5f0d6',
                'name' => 'Beans',
                'price' => 5.99,
            ],
            [
                'id' => '903cd4e9-1d44-47b9-8b50-abdbe57016c0',
                'name' => 'Spam',
                'price' => 3.50,
            ],
        ];

        $schema = $_ENV['DB_SCHEMA'];

        $table = $this->table("{$schema}.items");
        $table
            ->insert($data)
            ->save();
    }
}
