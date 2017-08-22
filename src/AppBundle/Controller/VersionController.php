<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Version;
use AppBundle\Entity\Resource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VersionController
 * @package AppBundle\Controller
 */
class VersionController extends Controller
{
    /**
     * @Route("/resources/{id}/new/version", name="resources_new_version")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Resource $id, Request $request)
    {
        $version = new Version();
        $form = $this->createForm('AppBundle\Form\VersionType', $version);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $version->getFile();

            if (!in_array($file->guessExtension(), ['txt', 'zip']) || !in_array($file->getClientOriginalExtension(), ['sk', 'zip'])) {
                $error = new FormError('Le fichier passé n\'est pas au bon format');
                $form->addError($error);
            } else {

                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('upload_directory'),
                    $fileName
                );

                $version->setFile($fileName);
                $version->setResource($id);

                $em = $this->getDoctrine()->getManager();
                $em->persist($version);
                $em->flush();
                return $this->redirectToRoute('resources_view', array('id' => $version->getResource()->getId()));
            }

        }

        return $this->render('resource/version.html.twig', array(
            'forms' => $form->createView()
        ));
    }
}
