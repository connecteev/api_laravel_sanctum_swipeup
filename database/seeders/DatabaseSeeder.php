<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\User;
use \App\Models\Category;
use \App\Models\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            ["id" => 1, "slug" => "work", "name" => "Work", "image" => "category-work", "color" => "color-red"],
            ["id" => 2, "slug" => "stress", "name" => "Stress", "image" => "category-stress", "color" => "color-blue"],
            ["id" => 3, "slug" => "frustration", "name" => "Frustration", "image" => "category-frustration", "color" => "color-green"],
            ["id" => 4, "slug" => "motivation", "name" => "Motivation", "image" => "category-motivation", "color" => "color-yellow"],
            ["id" => 5, "slug" => "anxiety", "name" => "Anxiety", "image" => "category-anxiety", "color" => "color-red"],
            ["id" => 6, "slug" => "sleep", "name" => "Sleep", "image" => "category-sleep", "color" => "color-blue"],
            ["id" => 7, "slug" => "sadness", "name" => "Sadness", "image" => "category-sadness", "color" => "color-green"],
            ["id" => 8, "slug" => "self-love", "name" => "Self-Love", "image" => "category-self-love", "color" => "color-white"]
        );
        // DB::table('categories')->insert($categories);
        Category::insert($categories);

        // User::factory(10)->create();
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $collections = Collection::factory()
            ->count(10)
            ->for($testUser)
            ->create();
    }
}
