<?php

namespace App\Http\Services\SitemapService;

use Psr\Http\Message\UriInterface;

class CrawlProfile extends \Spatie\Crawler\CrawlProfiles\CrawlProfile {
    public function shouldCrawl(UriInterface $url): bool
    {
        $path = $url->getPath();
        $serverHostName = pathinfo(env('APP_URL'))['basename'];
        $host = $url->getHost();
        print_r("$host\n");
        return strpos($path, '/blog') === false && $host === $serverHostName;
    }
}
