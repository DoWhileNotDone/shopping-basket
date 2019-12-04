<?php

use Phinx\Seed\AbstractSeed;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class BasketSeeder extends AbstractSeed
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
            [ //Basket with items
                'id' => 'fdde64c5-bd47-4657-9a57-103f61cbff47',
                'total' => 12.99
            ],
            [ //Empty Basket
                'id' => 'f37f72fe-40b9-4452-a7e4-0144cda1d7fb',
            ],
        ];

        $schema = $_ENV['DB_SCHEMA'];

        $table = $this->table("{$schema}.baskets");
        $table
            ->insert($data)
            ->save();
    }
}
