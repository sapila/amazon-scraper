<?php

namespace ScrapingService\Controller;

use Psr\Log\LoggerInterface;
use ScrapingService\Amazon\AmazonChromeCrawler;
use ScrapingService\Amazon\AmazonCrawler;
use ScrapingService\Amazon\AmazonGuzzleCrawler;
use ScrapingService\Amazon\Configuration\ProductPageCrawlerConfiguration;
use ScrapingService\Amazon\Scraper\ProductPageScraper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            // Inject this later
            $crawler = $this->getCrawler();
            $productHtml = $crawler->crawl($configuration);
            $logger->info('Got HTML. length : ' . (strlen($productHtml) > 250 ? 'got some page' : ' got les than 250'));
            $product = (new ProductPageScraper())->scrapProduct($productHtml);

        } catch (\Throwable $e) {
            $logger->error('ERROR: ' . $e->getMessage() . ' STACK : ' . $e->getTraceAsString());
            return new Response($e->getMessage(), 500);
        }

        return new JsonResponse($product->toArray(), 200);
    }

    private function getCrawler(): AmazonCrawler
    {
        return new AmazonGuzzleCrawler();
    }
}
