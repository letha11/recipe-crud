<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = User::factory(5)->create();

        foreach ($users as $user) {
            $recipe = Recipe::factory()->for($user)->create();

            foreach ($users as $rater) {
                if ($rater->isNot($user)) {
                    $recipe->ratings()->create(
                        [
                            'user_id' => $rater->id,
                            'rating' => rand(1, 5),
                        ]
                    );
                }
            }
        }


    }
}
