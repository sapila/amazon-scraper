<?php

namespace ScrapingService\Amazon\Crawler;

use ScrapingService\Amazon\Crawler\Configuration\ProductPageCrawlerConfiguration;
use Symfony\Component\Panther\Client;

class ChromeCrawler implements Crawler
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
