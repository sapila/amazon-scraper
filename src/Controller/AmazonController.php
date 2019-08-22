<?php

namespace ScrapingService\Controller;

use Psr\Log\LoggerInterface;
use ScrapingService\Amazon\AmazonCrawler;
use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;
use ScrapingService\Amazon\Scraper\ProductPageScraper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Panther\Client;

class AmazonController
{
    public function getProduct(Request $request,LoggerInterface $logger)
    {
        $configuration = new ProductPageCrawlerConfiguration(
            $request->get('locale'),
            $request->get('asin'),
            $request->get('title')
        );

        try {

            $client = Client::createChromeClient(
                null,
                ['--headless', '--disable-gpu', '--no-sandbox', '—-timeout=30000', '--proxy-server=37.97.228.147:24000']
            );

            $logger->info('Chrome started');

            // Inject this later
            $crawler = new AmazonCrawler($client);
            $productHtml = $crawler->crawl($configuration);
            $logger->info('Got HTML. length : ' . (strlen($productHtml) > 250 ? 'got some page' : ' got les than 250'));
            $crawler->quit();

            $product = (new ProductPageScraper())->scrapProduct($productHtml);

        } catch (\Throwable $e) {
            $logger->error('ERROR: ' . $e->getMessage() . ' STACK : ' . $e->getTraceAsString());
            return new Response($e->getMessage(), 500);
        }

        return new JsonResponse($product->toArray(), 200);
    }
}
