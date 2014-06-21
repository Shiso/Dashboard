<?php

namespace Dashboard\TicketsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Dashboard\TicketsBundle\Entity\Dash\Category;

class MenuController extends Controller
{
	public function menuAction($route)
	{
		$menu = array();
		if ($this->get('security.context')->isGranted("ROLE_USER")) {
			$menu[] = array('title' => "Mes tickets", 'link' => "dashboard_tickets_homepage", 'active' => 0);
			$menu[] = array('title' => "Nouveau ticket", 'link' => "dashboard_tickets_add", 'active' => 0);
		}
		if ($this->get('security.context')->isGranted("ROLE_ADMIN")) {
			$menu[] = array('title' => "Tickets administrés", 'link' => "dashboard_tickets_adminitred", 'active' => 0);
			$menu[] = array('title' => "Attribuer un ticket", 'link' => "dashboard_tickets_listNewsTickets", 'active' => 0);
			$menu[] = array('title' => "Ajouter une categorie", 'link' => "dashboard_category_add", 'active' => 0);
		}
		$endmenu = array();
		foreach ($menu as $item) {
			if ($item['link'] == $route)
				$item['active'] = 1;
			$endmenu[] = $item;
		}
		return $this->render("DashboardTicketsBundle:Menu:contextMenu.html.twig", array('menu' => $endmenu));
	}
}

	// <div id="sec-nav" class="col-sm-2" style="z-index:10;">
 //        <ul class="nav nav-pills nav-stacked">
	// 		<li><a href="{{ path('dashboard_tickets_homepage') }}">Mes tickets</a></li>
	// 		<li><a href="{{ path('dashboard_tickets_add') }}">Nouveau ticket</a></li>
	// 		{% if is_granted('ROLE_ADMIN') %}
	// 		<li><a href="{{ path('dashboard_tickets_adminitred') }}">Tickets administrés</a></li>
	// 		<li><a href="{{ path('dashboard_tickets_listNewsTickets') }}">Attribuer un ticket</a></li>
	// 		<li><a href="{{ path('dashboard_category_add') }}">Ajouter une categorie</a></li>
	// 		{% endif %}
	// 	</ul>
	// </div>