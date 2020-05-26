<?php

namespace ScrapingService\Amazon\Scraper;

use ScrapingService\Amazon\DTO\Product;

interface PageScraper
{
    public const DE = 'de';

    public function scrapProduct(string $html): Product;
}