<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            DB::table('products')->insert([
                'product_id' => strtoupper($faker->unique()->lexify('??????')),
                'product_name' => $faker->company,
                'product_value' => $faker->numberBetween(10, 100)

            ]);
        }
    }
}
