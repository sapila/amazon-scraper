<?php

namespace ScrapingService\Amazon\DTO;

class Product
{
    /** @var string */
    private $title;

    /** @var string[] */
    private $images;

    /** @var string[] */
    private $features;

    /** @var string|null */
    private $price;

    /** @var string|null */
    private $currency;

    /** @var string|null */
    private $brand;

    /** @var string|null */
    private $seller;

    /** @var string|null */
    private $dispatchedBy;

    /** @var string|null */
    private $deliveryDate;

    /** @var bool */
    private $available;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param string[] $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return string[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * @param string[] $features
     */
    public function setFeatures(array $features): void
    {
        $this->features = $features;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     */
    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     */
    public function setBrand(?string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return string|null
     */
    public function getSeller(): ?string
    {
        return $this->seller;
    }

    /**
     * @param string|null $seller
     */
    public function setSeller(?string $seller): void
    {
        $this->seller = $seller;
    }

    /**
     * @return string|null
     */
    public function getDispatchedBy(): ?string
    {
        return $this->dispatchedBy;
    }

    /**
     * @param string|null $dispatchedBy
     */
    public function setDispatchedBy(?string $dispatchedBy): void
    {
        $this->dispatchedBy = $dispatchedBy;
    }

    /**
     * @return string|null
     */
    public function getDeliveryDate(): ?string
    {
        return $this->deliveryDate;
    }

    /**
     * @param string|null $deliveryDate
     */
    public function setDeliveryDate(?string $deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->available;
    }

    /**
     * @param bool $available
     */
    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }

    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'images' => $this->getImages(),
            'features' => $this->getFeatures(),
            'price' => $this->getPrice(),
            'currency' => $this->getCurrency(),
            'brand' => $this->getBrand(),
            'seller' => $this->getSeller(),
            'dispatchedBy' => $this->getDispatchedBy(),
            'deliveryDate' => $this->getDeliveryDate(),
            'isAvailable' => $this->isAvailable()
        ];
    }
}
