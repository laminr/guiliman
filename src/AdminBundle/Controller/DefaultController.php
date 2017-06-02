<?php

namespace AdminBundle\Controller;

use AppBundle\Business\PollBusiness;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $news = $news = $this->get('news.service')->findAll();

        $questions = $this->get('question.service')->findAll();

        $dtos = [];
        foreach ($questions as $question) {
            $answers = [];
            foreach ($question->getAnswers() as $answer) {
                array_push($answers, [
                    'id' => $answer->getId(),
                    'label' => $answer->getLabel()
                ]);
            }

            array_push($dtos, [
                'id' => $question->getId(),
                'question' => $question->getLabel(),
                'answers' => $answers
            ]);
        }

        return $this->render('@Admin/Default/index.html.twig', array(
            'news' => $news,
            'dtos' => $dtos
        ));
    }
}
