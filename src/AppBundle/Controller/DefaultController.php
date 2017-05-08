<?php

namespace AppBundle\Controller;

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

        $questions = $this->get('question.service')->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'questions' => $questions
        ]);
    }
}
