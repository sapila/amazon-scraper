<?php

namespace ScrapingService\Tests\unit\Amazon\Scraper;

use ScrapingService\Amazon\Scraper\AmazonScraper;
use ScrapingService\Amazon\Scraper\AmazonScraperConfiguration;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AmazonScraperTest extends TestCase
{
    /**
     * @var AmazonScraper
     */
    private $scraper;

    protected function setUp()
    {
        parent::setUp();
        $this->scraper = new AmazonScraper(\Symfony\Component\Panther\Client::createChromeClient());
    }

    public function test_scrap()
    {
        $conf = new AmazonScraperConfiguration('de', 'B008TLGFW4', 'Some title');
        $product = $this->scraper->scrap($conf);

        var_dump($product);
    }
}
