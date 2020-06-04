<?php


namespace ScrapingService\Amazon\Crawler\Configuration;


use ScrapingService\Amazon\Request\ProductRequest;

class ProductPageCrawlerConfiguration
{
    /**
     * @var string
     */
    public $locale;

    /**
     * @var string
     */
    public $asin;

    /**
     * @var string|null
     */
    public $title;

    public function __construct(string $locale, string $asin, ?string $title)
    {
        $this->locale = $locale;
        $this->asin = $asin;
        $this->title = $title;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
    public function getAsin(): string
    {
        return $this->asin;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public static function fromProductRequest(ProductRequest $request)
    {
        return new ProductPageCrawlerConfiguration(
            $request->getLocale(),
            $request->getAsin(),
            $request->getTitle()
        );
    }
}