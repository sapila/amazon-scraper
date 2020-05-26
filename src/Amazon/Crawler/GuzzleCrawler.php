<?php

namespace ScrapingService\Amazon\Crawler;

use GuzzleHttp\Client;
use ScrapingService\Amazon\Configuration\CrawlerConfiguration;

class GuzzleCrawler implements Crawler
{
    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function crawl(CrawlerConfiguration $configuration): string
    {
        $client = new Client();
        $response = $client->request(
            'GET' ,
            'https://www.amazon.' . $configuration->getLocale() . '/dp/' . $configuration->getAsin()
        );

        if ($response->getStatusCode() !== 200) {
            return '';
        }

        return (string) $response->getBody();
    }
}
