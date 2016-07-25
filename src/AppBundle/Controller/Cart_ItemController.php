<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Cart_Item;
use AppBundle\Form\Cart_ItemType;

/**
 * Cart_Item controller.
 *
 * @Route("/cart_item")
 */
class Cart_ItemController extends Controller
{
    /**
     * Lists all Cart_Item entities.
     *
     * @Route("/", name="cart_item_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cart_Items = $em->getRepository('AppBundle:Cart_Item')->findAll();

        return $this->render('cart_item/index.html.twig', array(
            'cart_Items' => $cart_Items,
        ));
    }

    /**
     * Creates a new Cart_Item entity.
     *
     * @Route("/new", name="cart_item_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cart_Item = new Cart_Item();
        $form = $this->createForm('AppBundle\Form\Cart_ItemType', $cart_Item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cart_Item);
            $em->flush();

            return $this->redirectToRoute('cart_item_show', array('id' => $cart_Item->getId()));
        }

        return $this->render('cart_item/new.html.twig', array(
            'cart_Item' => $cart_Item,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cart_Item entity.
     *
     * @Route("/{id}", name="cart_item_show")
     * @Method("GET")
     */
    public function showAction(Cart_Item $cart_Item)
    {
        $deleteForm = $this->createDeleteForm($cart_Item);

        return $this->render('cart_item/show.html.twig', array(
            'cart_Item' => $cart_Item,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cart_Item entity.
     *
     * @Route("/{id}/edit", name="cart_item_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cart_Item $cart_Item)
    {
        $deleteForm = $this->createDeleteForm($cart_Item);
        $editForm = $this->createForm('AppBundle\Form\Cart_ItemType', $cart_Item);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cart_Item);
            $em->flush();

            return $this->redirectToRoute('cart_item_edit', array('id' => $cart_Item->getId()));
        }

        return $this->render('cart_item/edit.html.twig', array(
            'cart_Item' => $cart_Item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cart_Item entity.
     *
     * @Route("/{id}", name="cart_item_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cart_Item $cart_Item)
    {
        $form = $this->createDeleteForm($cart_Item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cart_Item);
            $em->flush();
        }

        return $this->redirectToRoute('cart_item_index');
    }

    /**
     * Creates a form to delete a Cart_Item entity.
     *
     * @param Cart_Item $cart_Item The Cart_Item entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cart_Item $cart_Item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cart_item_delete', array('id' => $cart_Item->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
