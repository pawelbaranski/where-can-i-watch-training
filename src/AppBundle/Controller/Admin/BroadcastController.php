<?php

namespace WhereCanIWatch\AppBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/broadcast")
 */
class BroadcastController extends Controller
{
    /**
     * @Route("/list")
     * @Method("GET")
     */
    public function listAction()
    {
        $broadcasts = $this
            ->get('app.broadcast_repository')
            ->findNotFinishedOrderedByTVChannelAndStartDate(new \DateTime());

        return $this->render('admin/broadcast/list.html.twig', ['broadcasts' => $broadcasts]);
    }
}