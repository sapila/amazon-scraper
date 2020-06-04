<?php

namespace ScrapingService\Amazon\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest
{
    /**
     * @Assert\EqualTo(value="de", message="Only 'de' is currently supported.")
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

    /**
     * ProductRequest constructor.
     */
    public function __construct(string $locale, string $asin, ?string $title)
    {
        $this->locale = $locale;
        $this->asin = $asin;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getAsin(): string
    {
        return $this->asin;
    }

    /**
     * @param string $asin
     */
    public function setAsin(string $asin): void
    {
        $this->asin = $asin;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
}
