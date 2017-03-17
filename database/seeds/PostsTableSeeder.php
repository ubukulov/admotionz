<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Posts as Posts;
class PostsTableSeeder extends Seeder
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
            Posts::create([
                'title' => $faker->sentence(),
                'description' => $faker->realText(150),
                'body' => $faker->realText(500),
                'img' => $faker->imageUrl('90','90',null,true,null),
                'id_cat' => rand(1,6),
                'id_user' => rand(1,10),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime()
            ]);
        }
    }
}
