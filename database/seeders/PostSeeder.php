<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $numOfPosts = 10;

        for ($i = 0; $i < $numOfPosts; $i++) {
            Post::create([
                'title' => $faker->sentence,       
                'content' => $faker->paragraph,      
            ]);
        }
    }
}
