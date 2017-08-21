<?php
/**
 * Created by PhpStorm.
 * User: laminr
 * Date: 21/08/2017
 * Time: 12:28
 */

namespace AdminBundle\Dto;


class QuestionResult
{
    private $question = "";

    private $polls = [];

    private $waitings = [];

    /**
     * @return mixed
     */
    public function getPolls()
    {
        return $this->polls;
    }

    /**
     * @param mixed $polls
     */
    public function setPolls($polls)
    {
        $this->polls = $polls;
    }

    /**
     * @return mixed
     */
    public function getWaitings()
    {
        return $this->waitings;
    }

    /**
     * @param mixed $waitings
     */
    public function setWaitings($waitings)
    {
        $this->waitings = $waitings;
    }


    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;
    }


}