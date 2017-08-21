<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Resource;
use AppBundle\Entity\Version;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class ResourcesController
 * @package AppBundle\Controller
 * @Route("/resources")
 */

class ResourcesController extends Controller
{

    /**
     * @Route("/view", name="resources_index")
     */
    public function showAction()
    {
        $ressources = $this
            ->getDoctrine()
            ->getRepository("AppBundle:Resource")
            ->findAll();

        return $this->render('resource/index.html.twig', array(
            'skripts' => $ressources
        ));
    }

    /**
     * @Route("/view/{id}", name="resources_view")
     * @param Resource $resource
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Resource $resource = null)
    {
        if (!$resource)
            return $this->redirectToRoute('resources_view');

        return $this->render('resource/view.html.twig', array(
            'resource' => $resource
        ));
    }

    /**
     * @Route("/download/{id}", name="resources_download")
     */
    public function downloadAction(Version $version = null)
    {
        if (!$version)
            return $this->redirectToRoute('resources_view');

        $file = file_get_contents($this->getParameter('upload_directory').'/'.$version->getFile());
        $extension = explode('.', $this->getParameter('upload_directory').'/'.$version->getFile())[1];
        $response = new Response($file);

        if($extension == 'zip') {
            $response->headers->set('Content-Type', 'application/octet-stream');
            $extension = 'zip';
        } else {
            $response->headers->set('Content-Type', 'text/plain');
            $extension = 'sk';
        }

        $fileName = $version->getResource()->getName().'_'.$version->getVersion().'.'.$extension;
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    /**
     * @Route("/new", name="resources_new")
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