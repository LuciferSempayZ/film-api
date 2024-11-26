<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            GenresSeeder::class,
            StudiosSeeder::class,
            AgeRatingsSeeder::class,
            MoviesSeeder::class,
            SerialsSeeder::class,
            FavoritesSeeder::class,
            RatingsSeeder::class,
            ActorsSeeder::class,
            MovieGenresSeeder::class,
            MovieActorsSeeder::class,
        ]);
    }
}
