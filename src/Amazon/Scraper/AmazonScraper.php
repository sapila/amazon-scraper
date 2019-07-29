<?php

namespace ScrapingService\Amazon\Scraper;

use ScrapingService\Amazon\Product;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

class AmazonScraper
{
    /**
     * @var Client
     */
    private $client;

    /**
     * AmazonScraper constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function scrap(AmazonScraperConfiguration $configuration): Product
    {
        $crawler = $this->client->request(
            'GET',
            'https://www.amazon.' . $configuration->getLocale() . '/dp/' . $configuration->getAsin()
        );

        return $this->scrapContent($crawler);
    }

    private function scrapContent(Crawler $crawler): Product
    {
        $product = new Product();

        $product->setTitle(
            $crawler->filter('#productTitle')->getText()
        );

        return $product;
    }
}
