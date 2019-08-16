<?php

namespace ScrapingService\Amazon;

use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;
use ScrapingService\Amazon\Scraper\ProductPageScraper;
use Symfony\Component\Panther\Client;

class AmazonCrawler
{
    /**
     * @var Client
     */
    private $client;

    /**
     * AmazonCrawler constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function scrap(ProductPageCrawlerConfiguration $configuration): Product
    {
        $crawler = $this->client->request(
            'GET',
            'https://www.amazon.' . $configuration->getLocale() . '/dp/' . $configuration->getAsin()
        );

        return (new ProductPageScraper())->scrapProduct($crawler->html());
    }
}
