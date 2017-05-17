<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Answer;
use AdminBundle\Entity\Poll;
use AppBundle\Business\PollBusiness;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Poll controller.
 *
 * @Route("poll")
 */
class PollController extends Controller
{
    /**
     * Lists all poll entities.
     *
     * @Route("/", name="poll_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if ($this->getUser()->getPerson() == null) {
            return $this->redirectToRoute('user_person_edit', ['id' => $this->getUser()->getId()]);
        }

        $dtos = [];
        $questions = $this->get('question.service')->findAll();

        $nbPerson = $this->get('person.service')->getNbPerson()["nbr"];
        $totalShare = $this->get('person.service')->getTotalShare()["nbr"];

        foreach ($questions as $question) {
            $dtos[] = PollBusiness::makePollPercent($question, $nbPerson, $totalShare);
        }

        // replace this example code with whatever you need
        return $this->render('poll/index.html.twig', [
            'dtos' => $dtos
        ]);
    }

    /**
     * Creates a new poll entity.
     *
     * @Route("/new/{id}", name="poll_person_answer")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newForUserAction(Request $request, $id = 0)
    {
        $person = $this->getUser()->getPerson();

        $poll = $this->get('poll.service')->findByPerson($id, $person);
        if ($poll != null) {
            return $this->redirectToRoute('poll_edit', [ 'id' => $poll->getId()]);
        }

        $poll = new Poll();
        $poll->setQuestion($this->get('question.service')->findById($id));
        $poll->setPerson($person);

        $form = $this->createForm('AdminBundle\Form\PollType', $poll, ['attr' => ['questionId' => $poll->getQuestion()]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($poll);
            $em->flush();

            //return $this->redirectToRoute('poll_show', array('id' => $poll->getId()));
            return $this->redirectToRoute('homepage');
        }

        return $this->render('poll/new.html.twig', array(
            'poll' => $poll,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing poll entity.
     *
     * @Route("/{id}/edit", name="poll_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Poll $poll)
    {
        $me = $this->getUser()->getPerson();

        $editForm = $this->createForm(
            'AdminBundle\Form\PollType',
            $poll,
            ['attr' => ['questionId' => $poll->getQuestion()]]
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $person = $editForm->getData()->getPerson();
            // vote for someone else
            if ($me != $person) {
                return $this->redirectToRoute(
                    'poll_answer_topool', [
                        'personId' => $person->getId(),
                        'questionId' => $poll->getQuestion()->getId(),
                        'answerId' =>  $poll->getAnswer()->getId()
                    ]
                );
            }
            // Just update
            else {
                $this->getDoctrine()->getManager()->flush();
            }

            return $this->redirectToRoute('poll_index');
        }

        return $this->render('poll/edit.html.twig', array(
            'poll' => $poll,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     *
     * @Route("/save/{personId}/{questionId}/{answerId}", name="poll_answer_topool")
     * @Method("GET")
     * @param Request $request
     * @param int $personId
     * @param int $questionId
     * @param int $answerId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setAnswerToPollAction(Request $request, $personId = 0, $questionId = 0, $answerId = 0)
    {

        $person = $this->get('person.service')->findById($personId);
        $answer = $this->get('answer.service')->findById($answerId);

        $service =  $this->get('poll.service');

        $poll = $service->findByPerson($questionId, $person);

        if ($poll != null) {
            $poll->setAnswer($answer);
            $service->save($poll);
        } else {
            $question = $this->get('question.service')->findById($questionId);

            $already = new Poll();
            $already->setQuestion($question);
            $already->setPerson($person);
            $already->setAnswer($answer);

            $service->save($already);
        }

        return $this->redirectToRoute('poll_index');
    }

}
