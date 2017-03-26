<?php

namespace WhereCanIWatch\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SearchController extends Controller
{
    /**
     * @Route("/search/{query}", name="search_broadcasts")
     * @Method("GET")
     */
    public function searchAction($query = null)
    {
        $broadcasts = $this->get('app.broadcast_repository')->findNotFinishedBefore($query, new \DateTime());

        return $this->render('search/search.html.twig', [
            'broadcasts' => $broadcasts
        ]);
    }
}