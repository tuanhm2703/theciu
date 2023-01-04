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
        Category::firstOrCreate([
            'name' => 'Áo khoác',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Áo kiểu',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Áo len',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Áo thun',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Sweater',
            'type' => CategoryType::PRODUCT,
            'parent_id' => Category::whereName('Áo thun')->whereType(CategoryType::PRODUCT)->first()->id
        ]);
        Category::firstOrCreate([
            'name' => 'Sơ mi',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Áo vest',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Chân váy',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Đầm',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Hàng lỗi',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Jumpsuit',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Phụ kiện',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Quần dài',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Quần jean',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Quần short',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Set đồ',
            'type' => CategoryType::PRODUCT
        ]);
        Category::firstOrCreate([
            'name' => 'Yếm',
            'type' => CategoryType::PRODUCT
        ]);
    }
}
