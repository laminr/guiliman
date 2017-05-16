<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Answer;
use AdminBundle\Entity\Poll;
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
     * @Route("/", name="_admin_poll_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $polls = $em->getRepository('AdminBundle:Poll')->findAll();

        return $this->render('poll/index.html.twig', array(
            'polls' => $polls,
        ));
    }

    /**
     * Creates a new poll entity.
     *
     * @Route("/new", name="_admin_poll_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $poll = new Poll();
        $form = $this->createForm('AdminBundle\Form\PollType', $poll);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($poll);
            $em->flush();

            return $this->redirectToRoute('poll_show', array('id' => $poll->getId()));
        }

        return $this->render('poll/new.html.twig', array(
            'poll' => $poll,
            'form' => $form->createView(),
        ));
    }
//
//    /**
//     * Creates a new poll entity.
//     *
//     * @Route("/new/{id}", name="poll_person_answer")
//     * @Method({"GET", "POST"})
//     * @param Request $request
//     * @param int $id
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function newForUserAction(Request $request, $id = 0)
//    {
//        $person = $this->getUser()->getPerson();
//
//        $poll = $this->get('poll.service')->findByPerson($person);
//        if ($poll != null) {
//            return $this->redirectToRoute('poll_edit', [ 'id' => $poll->getId()]);
//        }
//
//        $poll = new Poll();
//        $poll->setQuestion($this->get('question.service')->findById($id));
//        $poll->setPerson($person);
//
//        $form = $this->createForm('AdminBundle\Form\PollType', $poll);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($poll);
//            $em->flush();
//
//            //return $this->redirectToRoute('poll_show', array('id' => $poll->getId()));
//            return $this->redirectToRoute('homepage');
//        }
//
//        return $this->render('poll/new.html.twig', array(
//            'poll' => $poll,
//            'form' => $form->createView(),
//        ));
//    }

    /**
     * Finds and displays a poll entity.
     *
     * @Route("/{id}", name="poll_show")
     * @Method("GET")
     */
    public function showAction(Poll $poll)
    {
        $deleteForm = $this->createDeleteForm($poll);

        return $this->render('poll/show.html.twig', array(
            'poll' => $poll,
            'delete_form' => $deleteForm->createView(),
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

        $editForm = $this->createForm('AdminBundle\Form\PollType', $poll);
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
                echo 5;
                //$this->getDoctrine()->getManager()->flush();
            }

            return $this->redirectToRoute('homepage');
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
        echo "personId".$personId;
        echo "questionId".$questionId;
        echo "answer".$answerId;

        $person = $this->get('person.service')->findById($personId);
        $answer = $this->get('answer.service')->findById($answerId);

        $service =  $this->get('poll.service');

        $poll = $service->findByPerson($person);

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

        return $this->redirectToRoute('homepage');
    }

    /**
     * Deletes a poll entity.
     *
     * @Route("/{id}", name="poll_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Poll $poll)
    {
        $form = $this->createDeleteForm($poll);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($poll);
            $em->flush();
        }

        return $this->redirectToRoute('poll_index');
    }

    /**
     * Creates a form to delete a poll entity.
     *
     * @param Poll $poll The poll entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Poll $poll)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('poll_delete', array('id' => $poll->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
