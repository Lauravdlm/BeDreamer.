<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PlaceSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(RestaurantSeeder::class);
        $this->call(HotelSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FavoriteSeeder::class);
    }
}
