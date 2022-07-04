<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        User::factory(3)
            ->has(Article::factory()->count(random_int(2, 4)))
            ->create();
    }
}
