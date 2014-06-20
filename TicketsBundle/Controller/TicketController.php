<?php

namespace Dashboard\TicketsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

use Dashboard\TicketsBundle\Entity\Dash\Ticket;
use Dashboard\TicketsBundle\Entity\Dash\Category;
use Dashboard\TicketsBundle\Entity\Dash\status;
use Dashboard\TicketsBundle\Entity\Dash\Reponse;

class TicketController extends Controller
{
	// Liste les tickets crées par l'uutilisateur courant
	public function indexAction()
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$tickets = $this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\Ticket')
			->findByAuthorId($user->getId());
		$moar = array(array());
		foreach ($tickets as $key => $ticket) {
			$moar[$key]['ticket'] = $ticket;
			$moar[$key]['admin'] = $this->getAdmin($ticket);
			$moar[$key]['author'] = $this->getAuthor($ticket);
			$moar[$key]['category'] = $this->getCategory($ticket);
			$moar[$key]['status'] = $this->getStatus($ticket);
		}
		return $this->render('DashboardTicketsBundle:Ticket:test.html.twig', array('tdata' => $moar));
	}

	// Creation d'un ticket
	public function addTicketAction(Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$ticket = new Ticket();
		$ticket->setAuthorId($user->getId())
			->setAdminId(0)
			->setStatus(1)
			->setCreatedValue();
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

	// Focus sur un ticket
	public function voirAction($id, Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$ticket = $this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\Ticket')
			->find($id);

		if ($ticket->getAuthorId() == $user->getId() || $ticket->getAdminId() == $user->getId())
		{
			$moar = array();
			$moar['ticket'] = $ticket;
			$moar['admin'] = $this->getAdmin($ticket);
			$moar['author'] = $this->getAuthor($ticket);
			$moar['category'] = $this->getCategory($ticket);
			$moar['status'] = $this->getStatus($ticket);

			$reponses = $this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\Reponse')
			->findByIdTicket($ticket->getId());

			$moarRep = array(array());
			foreach ($reponses as $key => $rep) {
				$moarRep[$key]['reponse'] = $rep;
				$moarRep[$key]['author'] = $this->getAuthor($rep);
			}
			$reponse = new Reponse();
			$reponse->setAuthorId($user->getId())
				->setCreatedValue()
				->setIdTicket($ticket->getId());

			$form = $this->createFormBuilder($reponse)
				->add('Content', 'textarea')
				->add('Repondre', 'submit')
				->add('Close', 'submit')
				->getForm();

			if ($request->isMethod('POST')) {
				$form->bind($request);

				if ($form->isValid() && $ticket->getStatus() != 3) {
					$em = $this->getDoctrine()->getManager();
					$em->persist($reponse);
					if ($form->get('Close')->isClicked())
					{
						$ticket->setStatus(3);
						$em->persist($ticket);
					}
					$em->flush();

					return $this->redirect($this->generateUrl('dashboard_tickets_voir', array( 'id' => $id )));
				}
			}

			return $this->render('DashboardTicketsBundle:Ticket:voir.html.twig', array(
				'tdata' => $moar,
				'reponses' => $moarRep,
				'repForm' => $form->createView(),
				));
		}
		else
			return $this->redirect($this->generateUrl('dashboard_tickets_homepage', array('message' => "Vous ne pouvez acceder a ce ticket")));
	}

	// Voir les tickets non attribués
	public function listNewsTicketsAction()
	{
		$tickets = $this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\Ticket')
			->findByAdminId(0);
		$moar = array(array());
		foreach ($tickets as $key => $ticket) {
			$moar[$key]['ticket'] = $ticket;
			$moar[$key]['admin'] = $this->getAdmin($ticket);
			$moar[$key]['author'] = $this->getAuthor($ticket);
			$moar[$key]['category'] = $this->getCategory($ticket);
			$moar[$key]['status'] = $this->getStatus($ticket);
		}
		return $this->render('DashboardTicketsBundle:Ticket:test.html.twig', array(
			'tickets' => $tickets,
			'tdata' => $moar,
		));
	}

	// Attribution d'un ticket
	public function attributeAction($id, Request $request)
	{
		$ticket = $this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\Ticket')
			->find($id);

		$form = $this->createFormBuilder($ticket)
			->add('AdminId', 'entity', array(
				'class' => 'Setsuna\PrivateBundle\Entity\User',
				'property' => 'username',
				'query_builder' => function(EntityRepository $er) {
						return $er->createQueryBuilder('u')
							->where('u.roles LIKE :roles')
							->setParameter('roles', '%"ROLE_ADMIN"%');
				},
			))
			->getForm();

		if ($request->isMethod('POST')) {
			$form->bind($request);

			if ($form->isValid()) {
				$ticket->setStatus(2);
				$em = $this->getDoctrine()->getManager();
				$em->persist($ticket);
				$em->flush();

				return $this->redirect($this->generateUrl('dashboard_tickets_homepage'));
			}
		}
		return $this->render('DashboardTicketsBundle:Ticket:attribute.html.twig', array(
			'form' => $form->createView(),
			'ticket' => $ticket,
		));
	}

	public function administredAction()
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$tickets = $this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\Ticket')
			->findByAdminId($user->getId());
		$moar = array(array());
		foreach ($tickets as $key => $ticket) {
			$moar[$key]['ticket'] = $ticket;
			$moar[$key]['admin'] = $this->getAdmin($ticket);
			$moar[$key]['author'] = $this->getAuthor($ticket);
			$moar[$key]['category'] = $this->getCategory($ticket);
			$moar[$key]['status'] = $this->getStatus($ticket);
		}
		return $this->render('DashboardTicketsBundle:Ticket:test.html.twig', array('tdata' => $moar));
	}


	private function getAdmin($ticket)
	{
		$admin = $ticket->getAdminId();
		if ($admin)
			$admin = $this->getDoctrine()
				->getRepository('Setsuna\PrivateBundle\Entity\User')
				->find($admin);
		return $admin;
	}

	private function getAuthor($ticket)
	{
		$author = $ticket->getAuthorId();
		if ($author)
			$author = $this->getDoctrine()
				->getRepository('Setsuna\PrivateBundle\Entity\User')
				->find($author);
		return $author;
	}

	private function getCategory($ticket)
	{
		$category = $this->getDoctrine()->getRepository('Dashboard\TicketsBundle\Entity\Dash\Category')
			->find($ticket->getCategoryId());
		return $category;
	}

	private function getStatus($ticket)
	{
		$status = $this->getDoctrine()->getRepository('Dashboard\TicketsBundle\Entity\Dash\status')
			->find($ticket->getStatus());
		return $status;
	}

	// retourne une version textuelle du ticket en paramettre.
	private function textedTicket(Ticket $ticket)
	{
		$cat = $this->getDoctrine()->getRepository('Dashboard\TicketsBundle\Entity\Dash\Category')
			->find($ticket->getCategoryId());
		$ticket->setCategoryId($cat->getCatName());
		$ticket->setStatus($this->getDoctrine()
			->getRepository('Dashboard\TicketsBundle\Entity\Dash\status')
			->find($ticket->getStatus())->getStatusName());
		if ($ticket->getAdminId() == 0)
			$ticket->setAdminId("");
		else
			$ticket->setAdminId(
				$this->getDoctrine()
				->getRepository('Setsuna\PrivateBundle\Entity\User')
				->find($ticket->getAdminId())
				->getUsername()
			);
		return $ticket;
	}
}