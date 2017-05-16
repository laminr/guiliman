<?php
/**
 * Created by PhpStorm.
 * User: laminr
 * Date: 13/05/2017
 * Time: 11:33
 */

namespace AppBundle\Business;

use AdminBundle\Entity\Question;
use AppBundle\Dto\QuestionDto;

class PollBusiness
{

    public static function makePollPercent(Question $question, $totalPerson = 0, $totalShare = 1) {

        $answerShare = array();
        $shares = array();

        $personHadAnswered = sizeof($question->getPolls());
        $totalShareAnswered = 1;

        $labelOnlyAnswer = "Avec $personHadAnswered reponse(s) sur $totalPerson";
        $labelAllPerson = "Sur l'ensemble des parts";

        foreach ($question->getAnswers() as $answer) {
            $answerShare[$answer->getLabel()] = array();
        }

        // gather figures
        foreach ($question->getPolls() as $poll) {
            $person = $poll->getPerson();
            $answerShare[$poll->getAnswer()->getLabel()][] = $person->getShare();
            $totalShareAnswered += $person->getShare();
        }

        // calculate total
        foreach ($answerShare as $key => $values) {
            $total = 0.0;
            foreach ($values as $value) {
                $total += $value;
            }
            $shares[$key] = $total;
        }

        $statistics[$labelOnlyAnswer] = [];
        $statistics[$labelAllPerson] = [];

        foreach ($shares as $key => $value) {
            $statistics[$labelOnlyAnswer][$key] = number_format(($value / $totalShareAnswered) * 100, 2);
            $statistics[$labelAllPerson][$key] = number_format(($value / $totalShare) * 100, 2);
        }

        $dto = new QuestionDto();
        $dto->setQuestion($question);
        $dto->setPercents($statistics);

        return $dto;
    }
}