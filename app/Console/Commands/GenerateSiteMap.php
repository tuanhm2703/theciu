<?php

namespace App\Console\Commands;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically Generate an XML Sitemap';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categorySiteMap = Sitemap::create();
        $categories = Category::whereType(CategoryType::PRODUCT)->get();
        $categories->each(function (Category $category) use ($categorySiteMap) {
            $categorySiteMap->add(
                Url::create("/product-category/{$category->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        $categorySiteMap->writeToFile(public_path('sitemap.xml'));
    }
}
