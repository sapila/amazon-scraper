<?php


namespace ScrapingService\Amazon\Scraper;


use ScrapingService\Amazon\DTO\Product;

class ScraperFacade
{
    public function scrapProduct(string $html, string $locale): Product
    {
        switch ($locale) {
            case PageScraper::DE:
                return (new GermanProductPageScraper())->scrapProduct($html);
            default:
                throw new \Exception('Unsupported locale.');
        }
    }
}