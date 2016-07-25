<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Password_Reset_Token;
use AppBundle\Form\Password_Reset_TokenType;

/**
 * Password_Reset_Token controller.
 *
 * @Route("/password_reset_token")
 */
class Password_Reset_TokenController extends Controller
{
    /**
     * Lists all Password_Reset_Token entities.
     *
     * @Route("/", name="password_reset_token_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $password_Reset_Tokens = $em->getRepository('AppBundle:Password_Reset_Token')->findAll();

        return $this->render('password_reset_token/index.html.twig', array(
            'password_Reset_Tokens' => $password_Reset_Tokens,
        ));
    }

    /**
     * Creates a new Password_Reset_Token entity.
     *
     * @Route("/new", name="password_reset_token_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $password_Reset_Token = new Password_Reset_Token();
        $form = $this->createForm('AppBundle\Form\Password_Reset_TokenType', $password_Reset_Token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($password_Reset_Token);
            $em->flush();

            return $this->redirectToRoute('password_reset_token_show', array('id' => $password_Reset_Token->getId()));
        }

        return $this->render('password_reset_token/new.html.twig', array(
            'password_Reset_Token' => $password_Reset_Token,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Password_Reset_Token entity.
     *
     * @Route("/{id}", name="password_reset_token_show")
     * @Method("GET")
     */
    public function showAction(Password_Reset_Token $password_Reset_Token)
    {
        $deleteForm = $this->createDeleteForm($password_Reset_Token);

        return $this->render('password_reset_token/show.html.twig', array(
            'password_Reset_Token' => $password_Reset_Token,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Password_Reset_Token entity.
     *
     * @Route("/{id}/edit", name="password_reset_token_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Password_Reset_Token $password_Reset_Token)
    {
        $deleteForm = $this->createDeleteForm($password_Reset_Token);
        $editForm = $this->createForm('AppBundle\Form\Password_Reset_TokenType', $password_Reset_Token);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($password_Reset_Token);
            $em->flush();

            return $this->redirectToRoute('password_reset_token_edit', array('id' => $password_Reset_Token->getId()));
        }

        return $this->render('password_reset_token/edit.html.twig', array(
            'password_Reset_Token' => $password_Reset_Token,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Password_Reset_Token entity.
     *
     * @Route("/{id}", name="password_reset_token_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Password_Reset_Token $password_Reset_Token)
    {
        $form = $this->createDeleteForm($password_Reset_Token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($password_Reset_Token);
            $em->flush();
        }

        return $this->redirectToRoute('password_reset_token_index');
    }

    /**
     * Creates a form to delete a Password_Reset_Token entity.
     *
     * @param Password_Reset_Token $password_Reset_Token The Password_Reset_Token entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Password_Reset_Token $password_Reset_Token)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('password_reset_token_delete', array('id' => $password_Reset_Token->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
