<?php

namespace ScrapingService\Amazon\Scraper;

use ScrapingService\Amazon\DTO\Product;
use Symfony\Component\DomCrawler\Crawler;

class GermanProductPageScraper implements PageScraper
{
    /**
     * @var Crawler
     */
    private $crawler;

    public function scrapProduct(string $html): Product
    {
        $this->crawler = new Crawler($html);

        $product = new Product();

        $product->setTitle($this->scrapeTitle());
        $product->setFeatures($this->scrapeFeatures());
        $product->setPrice($this->scrapePrice());
        $product->setCurrency($this->scrapeCurrency());
        $product->setBrand($this->scrapeBrand());
        $product->setAvailable($this->scrapeAvailability());
        $product->setImages($this->scrapeImages());
        $sellerDispatcher = $this->scrapeSellerAndDispatchedBy();
        $product->setSeller($sellerDispatcher['seller']);
        $product->setDispatchedBy(($sellerDispatcher['dispatchedBy']));
        $product->setDeliveryDate($this->scrapeDeliveryDate());

        return $product;
    }


    private function scrapeTitle(): string
    {
        return trim($this->crawler->filter('#productTitle')->text(''));
    }

    private function scrapeImages(): array
    {
        $images = [];

        $this->crawler->filter('#altImages ul li')
            ->each(function ($node, $i) use (&$images) {

                try {
                    /** @var $node Crawler $image */
                    $image = $node->filter('img')->attr('src');
                } catch (\Exception $e ) {
                    return;
                }

                $imageUri = urldecode($image);

                if( !preg_match('/.*\.(?<searchTerm>.*)\.(?<extention>jpg|png)$/', $imageUri, $match)) {
                    return;
                }

                if (strpos($imageUri, 'icon') !== false) {
                    return;
                }

                $imageUri = preg_replace('/'.$match['searchTerm'].'/', '_SS500_', $imageUri);
                $images[] = $imageUri;
            });

        return array_values($images);
    }
    private function scrapeFeatures(): array
    {
        $features = $this->crawler->filter('#featurebullets_feature_div #feature-bullets ul li span')
            ->each(function(Crawler $node, $i) {
                $feature = trim($node->text(''));

                // TODO: check for that
                $skipStrings = [
                    'Geben Sie Ihr Modell ein,                um sicherzustellen, dass dieser Artikel passt.',
                    'um sicherzustellen, dass dieser Artikel passt.'
                ];

                // TODO: check for these
                //$feature = preg_replace('/(\r\n|\n|\r)/gm', "", $feature);

                return $feature;
            });

        return $features;
    }

    private function scrapePrice(): ?string
    {
        $price = $this->crawler->filter('#newBuyBoxPrice')->html(false);
        if (!$price) {
            $price = $this->crawler->filter('#priceblock_ourprice')->html(false);
        }

        if ($price) {
            return preg_replace('/[^0-9$.,]/', '', $price);
        }

        return null;
    }

    private function scrapeCurrency(): string
    {
        return 'EUR';
    }

    private function scrapeBrand(): ?string
    {
        return $this->crawler->filter('#bylineInfo')->text('');
    }

    private function scrapeAvailability(): bool
    {
        $availability = trim($this->crawler->filter('#availability span')->text(''));

        if ($availability == 'Auf Lager.') {
            return true;
        }

        $matched = preg_match('/Nur noch .* auf Lager.*/', $availability);

        return (bool) $matched;
    }

    private function scrapeSellerAndDispatchedBy(): array
    {
        $seller = null;
        $dispatchedBy = null;

        $links = [];
        $this->crawler->filter('#shipsFromSoldByInsideBuyBox_feature_div div #merchant-info a')
            ->each(function (Crawler $node, $i) use (&$links) {
                $links[] = $node->html('');
            });

        // Amazon seller - dispatcher
        if (count($links) === 0) {
            $sellerDispatchText = trim($this->crawler->filter('#shipsFromSoldByInsideBuyBox_feature_div div #merchant-info')->html(''));
            preg_match('/.*Verkauf und Versand durch (?<vendor>.*)\./', $sellerDispatchText, $matches);
            $seller = $dispatchedBy = $matches['vendor'] ?? '';
        }

        // Same seller - dispatcher
        if (count($links) === 1) {
            $seller = $dispatchedBy = $links[0];
        }

        // Different seller - dispatcher
        if (count($links) === 2) {
            $seller = $links[0];
            $dispatchedBy = trim(preg_replace('/Versand durch/', '', $links[1]));
        }

        return [
            'seller' => $seller,
            'dispatchedBy' => $dispatchedBy
        ];
    }

    public function scrapeDeliveryDate(): ?string
    {
        $deliveryDateBox = $this->crawler->filter('#ddmDeliveryMessage')->text('');

        if ($deliveryDateBox === '') {
            return '';
        }

        $months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];

        foreach ($months as $i => $month) {
            $monthPosition = strpos($deliveryDateBox, $month);
            if ($monthPosition !== false) {
                $deliveryDateBox = substr($deliveryDateBox, 0, $monthPosition+strlen($month));
                break;
            }
        }


        $hasDash = strpos($deliveryDateBox, '-');
        if ($hasDash !== false) {
            $deliveryDateBox = str_replace('Lieferung', '', $deliveryDateBox);
            $deliveryDateBox = preg_replace('/,.*/', '', $deliveryDateBox);
            $deliveryDateBox = preg_replace('/\./', '', $deliveryDateBox);
            $deliveryDateBox = trim($deliveryDateBox);
        } else {
            $deliveryDateBox = str_replace('Lieferung', '', $deliveryDateBox);
            $deliveryDateBox = preg_replace('/.*,/', '', $deliveryDateBox);
            $deliveryDateBox = preg_replace('/:.*/', '', $deliveryDateBox);
            $deliveryDateBox = preg_replace('/\./', '', $deliveryDateBox);
            $deliveryDateBox = trim($deliveryDateBox);
        }

        return $deliveryDateBox;
    }
}
