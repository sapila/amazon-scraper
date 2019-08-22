<?php

namespace ScrapingService\Amazon;

use GuzzleHttp\Client;
use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;

class AmazonGuzzleCrawler implements AmazonCrawler
{
    /**
     * @param ProductPageCrawlerConfiguration $configuration
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function crawl(ProductPageCrawlerConfiguration $configuration): string
    {
        $client = new Client();
        $response = $client->request(
            'GET' ,
            'https://www.amazon.' . $configuration->getLocale() . '/dp/' . $configuration->getAsin(),
            [
                'proxy' => 'http://37.97.228.147:24000'
            ]
        );

        if ($response->getStatusCode() !== 200) {
            return '';
        }

        return (string) $response->getBody();
    }
}
