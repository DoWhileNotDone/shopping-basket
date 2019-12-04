<?php

use Phinx\Seed\AbstractSeed;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class BasketLineSeeder extends AbstractSeed
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
                'basket_id' => 'fdde64c5-bd47-4657-9a57-103f61cbff47',
                'item_id' => '2b68ecfe-b00f-4574-9f0d-4a87f6e5f0d6',
                'quantity' => 1,
            ],
            [
                'basket_id' => 'fdde64c5-bd47-4657-9a57-103f61cbff47',
                'item_id' => '903cd4e9-1d44-47b9-8b50-abdbe57016c0',
                'quantity' => 2,
            ],
        ];

        $schema = $_ENV['DB_SCHEMA'];

        $table = $this->table("{$schema}.basket_lines");
        $table
            ->insert($data)
            ->save();
    }
}
