<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ResourcesController
 * @package AppBundle\Controller
 * @Route("/resources")
 */

class ResourcesController extends Controller
{

    /**
     * @Route("/view", name="resources_view")
     */

    public function showAction(){

        $ressources = $this
            ->getDoctrine()
            ->getRepository("AppBundle:Resource")
            ->findAll();

        return $this->render(':Resource:View.html.twig', array(
            'skripts' => $ressources
        ));
    }

    /**
     * @Route("/new", name="resources_view")
     */

    public function newAction(){

    }



}