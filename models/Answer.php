<?php


namespace models;


use core\DB;
use traits\HTML;


class Answer extends DB
{
    use HTML;

    private $link;
    private $length;
    private $questionId;


    public function __construct($link, $length, $questionId)
    {
        $this->link = $link;
        $this->length = $length;
        $this->questionId = $questionId;
    }

    public function store()
    {
        $matches = DB::getIdsByLink('answers', ROOT . $this->link);

        if (!$matches) {
            $data = [
                'link' => ROOT . $this->link,
                'length' => $this->length
            ];
            $answerId = DB::create('answers', $data);
        } else {
            $answerId = $matches['id'];
        }

        $data = [
            'question_id' => $this->questionId,
            'answer_id' => $answerId
        ];
        DB::create('questions_answers', $data);
    }
}