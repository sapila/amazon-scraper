<?php

namespace ScrapingService\Controller;

use ScrapingService\Amazon\AmazonCrawler;
use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Panther\Client;

class AmazonController
{
    public function getProduct(Request $request)
    {
        $configuration = new ProductPageCrawlerConfiguration(
            $request->get('locale'),
            $request->get('asin'),
            $request->get('title')
        );

        $crawler = new AmazonCrawler(
            Client::createChromeClient(
                null,
                ['--headless', '--disable-gpu', '--no-sandbox', '--proxy-server=37.97.228.147:24000']
            )
        );

        $product = $crawler->scrap($configuration);

        return new JsonResponse($product->toArray(), 200);
    }
}
