<?php

namespace ScrapingService\Controller;

use ScrapingService\Amazon\AmazonCrawler;
use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;
use ScrapingService\Amazon\Scraper\ProductPageScraper;
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

        $crawler = new AmazonCrawler( // Inject this later
            Client::createChromeClient(
                null,
                ['--headless', '--disable-gpu', '--no-sandbox', '—-timeout=30000', '--proxy-server=37.97.228.147:24000']
            )
        );

        $productHtml = $crawler->crawl($configuration);
        $crawler->quit();

        $product = (new ProductPageScraper())->scrapProduct($productHtml);

        return new JsonResponse($product->toArray(), 200);
    }
}
