<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{

    /**
     *
     * @Route("/set-person/{id}", name="user_person_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
echo 1;
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            echo 2;
            $me = $this->getUser();

            echo "is null:" . ($me->getPerson() == null);

            $me->setPerson($user->getPerson());
            $this->get('user.service')->save($me);

            return $this->redirectToRoute('homepage');
        }
echo 3;
        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView()
        ));
    }

}
