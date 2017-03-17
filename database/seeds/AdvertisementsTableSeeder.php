<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Advertisements as ADV;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,50) as $index){
            ADV::create([
                'title' => $faker->sentence(),
                'description' => $faker->realText(150),
                'full_text' => $faker->realText(500),
                'id_cat' => rand(1,6),
                'id_advertiser' => rand(3,12),
                'publish' => 1,
                'payment' => 0,
                'status' => 0,
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime()
            ]);
        }
    }
}
