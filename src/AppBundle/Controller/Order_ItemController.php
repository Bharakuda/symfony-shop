<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Order_Item;
use AppBundle\Form\Order_ItemType;

/**
 * Order_Item controller.
 *
 * @Route("/order_item")
 */
class Order_ItemController extends Controller
{
    /**
     * Lists all Order_Item entities.
     *
     * @Route("/", name="order_item_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $order_Items = $em->getRepository('AppBundle:Order_Item')->findAll();

        return $this->render('order_item/index.html.twig', array(
            'order_Items' => $order_Items,
        ));
    }

    /**
     * Creates a new Order_Item entity.
     *
     * @Route("/new", name="order_item_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $order_Item = new Order_Item();
        $form = $this->createForm('AppBundle\Form\Order_ItemType', $order_Item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order_Item);
            $em->flush();

            return $this->redirectToRoute('order_item_show', array('id' => $order_Item->getId()));
        }

        return $this->render('order_item/new.html.twig', array(
            'order_Item' => $order_Item,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Order_Item entity.
     *
     * @Route("/{id}", name="order_item_show")
     * @Method("GET")
     */
    public function showAction(Order_Item $order_Item)
    {
        $deleteForm = $this->createDeleteForm($order_Item);

        return $this->render('order_item/show.html.twig', array(
            'order_Item' => $order_Item,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Order_Item entity.
     *
     * @Route("/{id}/edit", name="order_item_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Order_Item $order_Item)
    {
        $deleteForm = $this->createDeleteForm($order_Item);
        $editForm = $this->createForm('AppBundle\Form\Order_ItemType', $order_Item);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order_Item);
            $em->flush();

            return $this->redirectToRoute('order_item_edit', array('id' => $order_Item->getId()));
        }

        return $this->render('order_item/edit.html.twig', array(
            'order_Item' => $order_Item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Order_Item entity.
     *
     * @Route("/{id}", name="order_item_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Order_Item $order_Item)
    {
        $form = $this->createDeleteForm($order_Item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order_Item);
            $em->flush();
        }

        return $this->redirectToRoute('order_item_index');
    }

    /**
     * Creates a form to delete a Order_Item entity.
     *
     * @param Order_Item $order_Item The Order_Item entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Order_Item $order_Item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('order_item_delete', array('id' => $order_Item->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
