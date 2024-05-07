<?php

namespace App\Http\Services\SitemapService;

use Psr\Http\Message\UriInterface;

class CrawlProfile extends \Spatie\Crawler\CrawlProfiles\CrawlProfile {
    public function shouldCrawl(UriInterface $url): bool
    {
        $path = $url->getPath();
        print_r("$path\n");
        return strpos($path, '/blog') === false;
    }
}
