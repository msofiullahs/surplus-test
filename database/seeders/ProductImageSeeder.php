<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'product_id'    => 1,
                'image_id'      => 1
            ],
            [
                'product_id'    => 1,
                'image_id'      => 2
            ],
            [
                'product_id'    => 1,
                'image_id'      => 3
            ],
            [
                'product_id'    => 2,
                'image_id'      => 1
            ],
            [
                'product_id'    => 2,
                'image_id'      => 2
            ],
            [
                'product_id'    => 2,
                'image_id'      => 3
            ],
            [
                'product_id'    => 3,
                'image_id'      => 1
            ],
            [
                'product_id'    => 3,
                'image_id'      => 2
            ],
            [
                'product_id'    => 3,
                'image_id'      => 3
            ]
        ];
        DB::table('product_image')->insert($data);
    }
}
