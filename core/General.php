<?php


namespace core;


use GuzzleHttp\Client;
use models\Answer;
use models\Letter;
use models\Question;


class General
{
    private $proxyPool;
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 300,
            'curl' => [ CURLOPT_SSLVERSION => 1 ],
        ]);

        $params = require 'config/params.php';
        $this->proxyPool = new ProxyPool($params['proxiesLink']);
    }

    public function parseWholeSite()
    {
        foreach (range('a', 'z') as $letter) {
            $pid = pcntl_fork();
            if ($pid == 0) {
                $letter = new Letter($letter);
                $questionsLinks = $letter->parse($this->proxyPool, $this->client);
                foreach ($questionsLinks as $questionLink) {

                    $question = new Question($questionLink);
                    $answers = $question->parse($this->proxyPool, $this->client);

                    $questionId = $answers[0];
                    unset($answers[0]);

                    foreach ($answers as $link => $length) {
                        $answer = new Answer($link, $length, $questionId);
                        $answer->store();
                    }
                }

                exit();
            }
        }
    }

}