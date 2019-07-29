<?php

namespace ScrapingService\Controller;

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function index()
    {
        return new Response('got it');

        $client = \Symfony\Component\Panther\Client::createChromeClient();
        //$client->close();
        $client->quit();
        $crawler = $client->request('GET', 'https://api.ipify.org'); // Yes, this website is 100% in JavaScript
        $client->quit();

        return new Response('got it');
    }
}
