<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Person;
use AdminBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{

    /**
     * Displays a form to edit an existing question entity.
     *
     * @Route("/{id}/edit", name="user_person_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        echo "TYPE=".($request->isMethod('POST') == true ? " POST " : " GET ");

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $service = $this->get('person.service');
            $previousPerson = $service->getPersonForUser($user->getId());

            if ($previousPerson != null) {
                foreach ($previousPerson as $old) {
                    print_r(sizeof($old));
                    $old->setUserNull();
                    $service->save($old);
                }
            }

            $p = $service->findById($user->getPerson()->getId());
            $p->setUser($user);
            $service->save($p);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView()
        ));
    }

}
