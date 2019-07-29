<?php

require __DIR__ . '/../vendor/autoload.php';


$client = \Symfony\Component\Panther\Client::createChromeClient();

$crawler = $client->request('GET', 'https://www.amazon.de/dp/B008TLGFW4');

file_put_contents('B008TLGFW4.html', $crawler->html());

exit(0);

$conf = new \ScrapingService\Amazon\Scraper\AmazonScraperConfiguration('de', 'B008TLGFW4', 'Some title');

$scraper = new \ScrapingService\Amazon\Scraper\AmazonScraper(\Symfony\Component\Panther\Client::createChromeClient());

$product = $scraper->scrap($conf);

var_dump($product);
