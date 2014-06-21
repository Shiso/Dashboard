<?php

namespace Dashboard\TicketsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

use Dashboard\TicketsBundle\Entity\Dash\Category;

class CategoryController extends Controller
{
	public function addCategoryAction(Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$category = new Category();
		$form = $this->createFormBuilder($category)
			->add('catName', 'text')
			->add('Ajouter', 'submit')
			->getForm();

		if ($request->isMethod('POST')) {
			$form->bind($request);

			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($category);
				$em->flush();

				return $this->redirect($this->generateUrl('dashboard_category_add'));
			}
		}
		return $this->render('DashboardTicketsBundle:Category:add.html.twig', array(
			'form' => $form->createView(),
		));		
	}
}
