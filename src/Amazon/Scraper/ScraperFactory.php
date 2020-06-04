<?php


namespace ScrapingService\Amazon\Scraper;


class ScraperFactory
{
    public function getForLocale(string $locale): PageScraper
    {
        switch ($locale) {
            case PageScraper::DE:
                return new GermanProductPageScraper();
            default:
                throw new \Exception('Unsupported locale.');
        }
    }
}