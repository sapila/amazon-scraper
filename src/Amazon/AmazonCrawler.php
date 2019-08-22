<?php

namespace ScrapingService\Amazon;

use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;
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

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function crawl(ProductPageCrawlerConfiguration $configuration): string
    {
        $crawler = $this->client->request(
            'GET',
            'https://www.amazon.' . $configuration->getLocale() . '/dp/' . $configuration->getAsin()
        );

        return $crawler->html();
    }

    public function quit(): void
    {
        $this->client->close();
        $this->client->quit();
    }
}
