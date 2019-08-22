<?php

namespace ScrapingService\Amazon;

use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;
use Symfony\Component\Panther\Client;

class AmazonChromeCrawler implements AmazonCrawler
{
    public function crawl(ProductPageCrawlerConfiguration $configuration): string
    {
        $client = Client::createChromeClient(
            null,
            ['--headless', '--disable-gpu', '--no-sandbox', '—-timeout=30000', '--proxy-server=37.97.228.147:24000']
        );

        $crawler = $client->request(
            'GET',
            'https://www.amazon.' . $configuration->getLocale() . '/dp/' . $configuration->getAsin()
        );

        $client->close();
        $client->quit();

        return $crawler->html();
    }
}
