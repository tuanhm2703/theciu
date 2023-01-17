<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shirtCat = Category::firstOrCreate([
            'name' => 'Áo',
            'type' => CategoryType::PRODUCT
        ]);
        $shirtCat->categories()->firstOrCreate([
            'name' => 'Áo thun',
            'type' => CategoryType::PRODUCT,
        ]);
        $shirtCat->categories()->firstOrCreate([
            'name' => 'Sơ mi',
            'type' => CategoryType::PRODUCT
        ]);
        $shirtCat->categories()->firstOrCreate([
            'name' => 'Áo kiểu',
            'type' => CategoryType::PRODUCT
        ]);
        $shirtCat->categories()->firstOrCreate([
            'name' => 'Áo hai dây và ba lỗ',
            'type' => CategoryType::PRODUCT
        ]);
        $shirtCat->categories()->firstOrCreate([
            'name' => 'Áo polo',
            'type' => CategoryType::PRODUCT
        ]);
        $shirtCat->categories()->firstOrCreate([
            'name' => 'Áo len',
            'type' => CategoryType::PRODUCT
        ]);
        $shirtCat->categories()->firstOrCreate([
            'name' => 'Khác',
            'type' => CategoryType::PRODUCT
        ]);
        $pantCat = Category::firstOrCreate([
            'name' => 'Quần',
            'type' => CategoryType::PRODUCT
        ]);
        $pantCat->categories()->firstOrCreate([
            'name' => 'Quần dài',
            'type' => CategoryType::PRODUCT
        ]);
        $pantCat->categories()->firstOrCreate([
            'name' => 'Quần jean',
            'type' => CategoryType::PRODUCT
        ]);
        $pantCat->categories()->firstOrCreate([
            'name' => 'Quần short',
            'type' => CategoryType::PRODUCT
        ]);
        $skirtCat = Category::firstOrCreate([
            'name' => 'Chân váy',
            'type' => CategoryType::PRODUCT
        ]);
        $skirtCat->categories()->firstOrCreate([
            'name' => 'Chân váy ngắn',
            'type' => CategoryType::PRODUCT
        ]);
        $skirtCat->categories()->firstOrCreate([
            'name' => 'Chân váy midi',
             'type' => CategoryType::PRODUCT
        ]);
        $dressCat = Category::firstOrCreate([
            'name' => 'Đầm',
            'type' => CategoryType::PRODUCT
        ]);
        $dressCat->categories()->firstOrCreate([
            'name' => 'Đầm ngắn',
            'type' => CategoryType::PRODUCT
        ]);
        $dressCat->categories()->firstOrCreate([
            'name' => 'Đầm maxi',
            'type' => CategoryType::PRODUCT
        ]);
        $coatCat = Category::firstOrCreate([
            'name' => 'Áo khoác',
            'type' => CategoryType::PRODUCT,
        ]);
        $coatCat->categories()->firstOrCreate([
            'name' => 'Áo khoác dây kéo',
            'type' => CategoryType::PRODUCT,
        ]);
        $coatCat->categories()->firstOrCreate([
            'name' => 'Hoodie',
            'type' => CategoryType::PRODUCT,
        ]);
        $coatCat->categories()->firstOrCreate([
            'name' => 'Sweater',
            'type' => CategoryType::PRODUCT,
        ]);
        $coatCat->categories()->firstOrCreate([
            'name' => 'Áo vest & blazer',
            'type' => CategoryType::PRODUCT,
        ]);
        $setCat = Category::firstOrCreate([
            'name' => 'Bộ',
            'type' => CategoryType::PRODUCT
        ]);
        $setCat->categories()->firstOrCreate([
            'name' => 'Set bộ',
            'type' => CategoryType::PRODUCT
        ]);
        $setCat->categories()->firstOrCreate([
            'name' => 'Jumpsuit',
            'type' => CategoryType::PRODUCT
        ]);
        $bibsCat = Category::firstOrCreate([
            'name' => 'Yếm',
            'type' => CategoryType::PRODUCT
        ]);
        $bibsCat->categories()->firstOrCreate([
            'name' => 'Yếm quần',
            'type' => CategoryType::PRODUCT
        ]);
        $bibsCat->categories()->firstOrCreate([
            'name' => 'Yếm váy',
            'type' => CategoryType::PRODUCT
        ]);
    }
}
