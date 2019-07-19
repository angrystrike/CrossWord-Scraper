<?php


namespace models;


use core\DB;
use core\ProxyPool;
use GuzzleHttp\Client;
use traits\HTML;


class Letter extends DB
{
    use HTML;

    private $letter;

    public function __construct($letter)
    {
        $this->letter = $letter;
    }

    public function parse(ProxyPool $proxyPool, Client $client)
    {
        $content = self::getHTML(ROOT . $this->letter, $proxyPool, $client);
        $links = $content->find('.dnrg li a');

        $questionsPagesLinks = [];
        foreach ($links as $link) {
            $questionsPagesLinks[] = $link->attr('href');
        }

        $questionsLinks = [];

        foreach ($questionsPagesLinks as $questionsPageLink) {
            $questionsPage = self::getHTML(ROOT . $questionsPageLink, $proxyPool, $client);
            $links = $questionsPage->find('.Question a');

            foreach ($links as $link) {
                $questionsLinks[] = $link->attr('href');
            }
        }

        $questionsLinks = array_unique($questionsLinks);
        return $questionsLinks;
    }
}