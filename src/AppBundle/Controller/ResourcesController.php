<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ResourcesController extends Controller
{

    /**
     * @Route("/view/resources/", name="resources_view")
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



}