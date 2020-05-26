<?php

namespace ScrapingService\Amazon\Service;

use ScrapingService\Amazon\Configuration\CrawlerConfiguration;
use ScrapingService\Amazon\Crawler\Crawler;
use ScrapingService\Amazon\DTO\Product;
use ScrapingService\Amazon\Scraper\ScraperFacade;

class AmazonService
{
    /**
     * @var Crawler
     */
    private $crawler;
    /**
     * @var ScraperFacade
     */
    private $scraperFacade;

    /**
     * AmazonService constructor.
     */
    public function __construct(Crawler $crawler, ScraperFacade $scraperFacade)
    {
        $this->crawler = $crawler;
        $this->scraperFacade = $scraperFacade;
    }

    public function fetch(CrawlerConfiguration $request): Product
    {
        return $this->scraperFacade->scrapProduct(
            $this->crawler->crawl($request),
            $request->getLocale()
        );
    }
}