<?php

namespace ScrapingService\Amazon;

use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;

interface AmazonCrawler
{
    public function crawl(ProductPageCrawlerConfiguration $configuration): string;
}
