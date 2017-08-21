<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Resource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function showAction()
    {

        $ressources = $this
            ->getDoctrine()
            ->getRepository("AppBundle:Resource")
            ->findAll();

        return $this->render('resource/view.html.twig', array(
            'skripts' => $ressources
        ));
    }

    /**
     * @Route("/new", name="resources_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request)
    {
        $Resource = new Resource();
        $form = $this->createForm('AppBundle\Form\ResourceType', $Resource);
        $form->handleRequest($request);

        return $this->render('resource/new.html.twig', array(
            'forms' => $form->createView()
        ));
    }



}