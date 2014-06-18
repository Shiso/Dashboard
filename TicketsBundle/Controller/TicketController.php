<?php

namespace Dashboard\TicketsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Dashboard\TicketsBundle\Entity\Dash\Ticket;
use Dashboard\TicketsBundle\Entity\Dash\Category;
use Dashboard\TicketsBundle\Entity\Dash\status;

class TicketController extends Controller
{
	public function indexAction()
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$tickets = $this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\Ticket')
			->findByAuthorId($user->getId());
		foreach ($tickets as $key => $ticket) {
			$ticket->setCategoryId($this->getDoctrine()
				->getRepository('Dashboard\TicketsBundle\Entity\Dash\Category')
				->find($ticket->getCategoryId())->getCatName());
			$ticket->setStatus($this->getDoctrine()
				->getRepository('Dashboard\TicketsBundle\Entity\Dash\status')
				->find($ticket->getStatus())->getStatusName());
		}
		return $this->render('DashboardTicketsBundle:Ticket:test.html.twig', array('tickets' => $tickets));
	}

	public function addTicketAction(Request $request)
	{
		$ticket = new Ticket();
		$ticket->setAuthorId(1)
			->setAdminId(0)
			->setStatus(1);
		$form = $this->createFormBuilder($ticket)
			->add('title', 'text')
			->add('categoryId', 'entity', array(
				'class' => 'Dashboard\TicketsBundle\Entity\Dash\Category',
				'property' => 'catName'))
			->add('Content', 'textarea')
			->getForm();

		if ($request->isMethod('POST')) {
			$form->bind($request);

			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($ticket);
				$em->flush();

				return $this->redirect($this->generateUrl('dashboard_tickets_homepage'));
			}
		}
		return $this->render('DashboardTicketsBundle:Ticket:add.html.twig', array(
			'form' => $form->createView(),
		));
	}
}