<?php

namespace ScrapingService\Amazon\Crawler;

use ScrapingService\Amazon\Crawler\Configuration\ProductPageCrawlerConfiguration;

interface Crawler
{
    public function crawl(ProductPageCrawlerConfiguration $configuration): string;
}
