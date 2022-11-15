<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ChatRoom;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ["nameAr" => "شخصية", "nameEn" => "Personal"],
            ["nameAr" => "طعام", "nameEn" => "Food"],
            ["nameAr" => "اقتصاد", "nameEn" => "Economie"],
            ["nameAr" => "الموضة", "nameEn" => "Fashion"],
            ["nameAr" => " التكنولوجيا", "nameEn" => "Technology"],
            ["nameAr" => " الكتب", "nameEn" => "Books"],
            ["nameAr" => " الألعاب", "nameEn" => "Games"],
            ["nameAr" => " سيارات", "nameEn" => "Cars"],
        ]);
    }
}
