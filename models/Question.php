<?php


namespace models;


use core\DB;
use traits\HTML;


class Question extends DB
{
    use HTML;

    private $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function parse($proxyPool, $client)
    {
        $questionPage = self::getHTML(ROOT . $this->link, $proxyPool, $client);

        $matches = DB::getIdsByLink('questions', ROOT . $this->link);

        if (!$matches) {
            $lastQuestionId = DB::create('questions', ['link' => ROOT . $this->link]);
        } else {
            $lastQuestionId = $matches['id'];
        }

        $lengths = $questionPage->find('tbody .Length');
        $answersLinks = $questionPage->find('tbody .Answer a');

        $questionData[] = $lastQuestionId;
        foreach ($answersLinks as $key => $link) {
            $questionData += [$link->attr('href') => $lengths[$key]->text()];
        }

        return $questionData;
    }
}