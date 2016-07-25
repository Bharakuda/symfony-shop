<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Customer_Order;
use AppBundle\Form\Customer_OrderType;

/**
 * Customer_Order controller.
 *
 * @Route("/customer_order")
 */
class Customer_OrderController extends Controller
{
    /**
     * Lists all Customer_Order entities.
     *
     * @Route("/", name="customer_order_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customer_Orders = $em->getRepository('AppBundle:Customer_Order')->findAll();

        return $this->render('customer_order/index.html.twig', array(
            'customer_Orders' => $customer_Orders,
        ));
    }

    /**
     * Creates a new Customer_Order entity.
     *
     * @Route("/new", name="customer_order_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $customer_Order = new Customer_Order();
        $form = $this->createForm('AppBundle\Form\Customer_OrderType', $customer_Order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer_Order);
            $em->flush();

            return $this->redirectToRoute('customer_order_show', array('id' => $customer_Order->getId()));
        }

        return $this->render('customer_order/new.html.twig', array(
            'customer_Order' => $customer_Order,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Customer_Order entity.
     *
     * @Route("/{id}", name="customer_order_show")
     * @Method("GET")
     */
    public function showAction(Customer_Order $customer_Order)
    {
        $deleteForm = $this->createDeleteForm($customer_Order);

        return $this->render('customer_order/show.html.twig', array(
            'customer_Order' => $customer_Order,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Customer_Order entity.
     *
     * @Route("/{id}/edit", name="customer_order_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Customer_Order $customer_Order)
    {
        $deleteForm = $this->createDeleteForm($customer_Order);
        $editForm = $this->createForm('AppBundle\Form\Customer_OrderType', $customer_Order);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer_Order);
            $em->flush();

            return $this->redirectToRoute('customer_order_edit', array('id' => $customer_Order->getId()));
        }

        return $this->render('customer_order/edit.html.twig', array(
            'customer_Order' => $customer_Order,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Customer_Order entity.
     *
     * @Route("/{id}", name="customer_order_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Customer_Order $customer_Order)
    {
        $form = $this->createDeleteForm($customer_Order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($customer_Order);
            $em->flush();
        }

        return $this->redirectToRoute('customer_order_index');
    }

    /**
     * Creates a form to delete a Customer_Order entity.
     *
     * @param Customer_Order $customer_Order The Customer_Order entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Customer_Order $customer_Order)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_order_delete', array('id' => $customer_Order->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
