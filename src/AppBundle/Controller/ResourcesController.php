<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Resource;
use AppBundle\Entity\Version;
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
     * @Route("/new1", name="resources_new1")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request)
    {
        $resource = new Resource();
        $form = $this->createForm('AppBundle\Form\ResourceType', $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resource);
            $em->flush();
            return $this->redirectToRoute('resources_new_version', array('id' => $resource->getId()));
        }

        return $this->render('resource/new.html.twig', array(
            'forms' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/new/version", name="resources_new_version")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function newVersionAction(Resource $id, Request $request)
    {
        $version = new Version();
        $form = $this->createForm('AppBundle\Form\VersionType', $version);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $version->getFile();
            dump($file);

            $em = $this->getDoctrine()->getManager();
            $version->setResource($id);
            $em->persist($version);
            $em->flush();


        }

        return $this->render('resource/version.html.twig', array(
            'forms' => $form->createView()
        ));
    }


}