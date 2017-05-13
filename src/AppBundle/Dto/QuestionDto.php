<?php
/**
 * Created by PhpStorm.
 * User: laminr
 * Date: 13/05/2017
 * Time: 11:59
 */

namespace AppBundle\Dto;


class QuestionDto
{

    public $question;

    public $percents = [];

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return array
     */
    public function getPercents()
    {
        return $this->percents;
    }

    /**
     * @param array $percents
     */
    public function setPercents($percents)
    {
        $this->percents = $percents;
    }

}