<?php

namespace ScrapingService\Amazon\Service;

use ScrapingService\Amazon\Crawler\Configuration\ProductPageCrawlerConfiguration;
use ScrapingService\Amazon\Crawler\Crawler;
use ScrapingService\Amazon\DTO\Product;
use ScrapingService\Amazon\Request\ProductRequest;
use ScrapingService\Amazon\Scraper\ScraperFactory;

class AmazonService
{
    /**
     * @var Crawler
     */
    private $crawler;
    /**
     * @var ScraperFactory
     */
    private $scraperFactory;

    /**
     * AmazonService constructor.
     */
    public function __construct(Crawler $crawler, ScraperFactory $scraperFactory)
    {
        $this->crawler = $crawler;
        $this->scraperFactory = $scraperFactory;
    }

    public function fetch(ProductRequest $request): Product
    {
        $body = $this->crawler->crawl(
            ProductPageCrawlerConfiguration::fromProductRequest($request)
        );

        $scraper = $this->scraperFactory->getForLocale($request->getLocale());
        return $scraper->scrapProduct($body);
    }
}