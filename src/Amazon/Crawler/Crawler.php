<?php

namespace ScrapingService\Amazon\Crawler;

use ScrapingService\Amazon\Configuration\CrawlerConfiguration;

interface Crawler
{
    public function crawl(CrawlerConfiguration $configuration): string;
}
