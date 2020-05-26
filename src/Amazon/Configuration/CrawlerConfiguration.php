<?php


namespace ScrapingService\Amazon\Configuration;


interface CrawlerConfiguration
{
    public function getLocale(): string;
    public function getAsin(): string;
    public function getTitle(): ?string;
}