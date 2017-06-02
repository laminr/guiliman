<?php

namespace AppBundle\Controller;

use AppBundle\Business\PollBusiness;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if ($this->getUser()->getPerson() == null) {
            return $this->redirectToRoute('user_person_edit', ['id' => $this->getUser()->getId()]);
        }

        $dtos = [];
        $questions = $this->get('question.service')->findAll();
        $news = $this->get('news.service')->findAllPublished();

        $nbPerson = $this->get('person.service')->getNbPerson()["nbr"];
        $totalShare = $this->get('person.service')->getTotalShare()["nbr"];

        foreach ($questions as $question) {
            $dtos[] = PollBusiness::makePollPercent($question, $nbPerson, $totalShare);
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'dtos' => $dtos,
            'news' => $news
        ]);
    }
}
