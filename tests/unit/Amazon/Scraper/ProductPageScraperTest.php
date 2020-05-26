<?php

namespace ScrapingService\Tests\unit\Amazon\Scraper;

use ScrapingService\Amazon\Product;
use ScrapingService\Amazon\Scraper\GermanProductPageScraper;
use Symfony\Component\Panther\PantherTestCase;

class ProductPageScraperTest extends PantherTestCase
{
    /**
     * @var GermanProductPageScraper
     */
    private $scraper;

    /** @var Product */
    private $product1;
    /** @var Product */
    private $product2;
    /** @var Product */
    private $product3;

    protected function setUp()
    {
        parent::setUp();
        $this->scraper = new GermanProductPageScraper();
        $this->product1 = $this->scraper->scrapProduct(
            file_get_contents(__DIR__ . '/../../../fictures/Amazon/Scraper/B07H9V2888.html')
        );
        $this->product2 = $this->scraper->scrapProduct(
            file_get_contents(__DIR__ . '/../../../fictures/Amazon/Scraper/B07SPWLK8R.html')
        );
        $this->product3 = $this->scraper->scrapProduct(
            file_get_contents(__DIR__ . '/../../../fictures/Amazon/Scraper/B008TLGFW4.html')
        );
    }

    public function test_scraping_seller()
    {
        $this->assertEquals('AllMates', $this->product1->getSeller());
        $this->assertEquals('Quick WinOut', $this->product2->getSeller());
        $this->assertEquals('Amazon', $this->product3->getSeller());

        $this->assertTrue(true);
    }

    public function test_scraping_dispatchedBy()
    {
        $this->assertEquals('Amazon', $this->product1->getDispatchedBy());
        $this->assertEquals('Quick WinOut', $this->product2->getDispatchedBy());
        $this->assertEquals('Amazon', $this->product3->getDispatchedBy());
    }
}
