<?php

namespace Dashboard\TicketsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dashboard\TicketsBundle\Entity\Dash\Ticket;
use Dashboard\TicketsBundle\Entity\Dash\Category;

class TicketController extends Controller
{
	public function indexAction()
	{
		return $this->render('DashboardTicketsBundle:Ticket:test.html.twig', array('name' => "Théo"));
	}

	public function addTicketAction()
	{
		$ticket = new Ticket();
		$ticket->setAuthorId(42)
			->setAdminId(0)
			->setStatus(1);
		$form = $this->createFormBuilder($ticket)
			->add('title', 'text')
			->add('Categorie', 'entity', array(
				'class' => 'Dashboard\TicketsBundle\Entity\Dash\Category',
				'property' => 'catName'))
			->add('Content', 'textarea')
			->add('Envoyer le ticket', 'submit')
			->getForm();

		return $this->render('DashboardTicketsBundle:Ticket:add.html.twig', array(
            'form' => $form->createView(),
        ));
	}
}