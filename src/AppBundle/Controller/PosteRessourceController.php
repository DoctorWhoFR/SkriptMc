<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PosteRessourceController extends Controller
{

    /**
     * @Route("/posteressource/")
     */

    public function showAction(Request $request)
    {
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'skriptmc');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        $odb = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);

        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('name', TextType::class, array('label' => 'Nom du Skript:', 'attr'=> array('class'=>'form-control')))
            ->add('version', TextType::class,  array('label' => 'Version:', 'attr'=> array('class'=>'form-control')))
            ->add('description', TextType::class,  array('label' => 'Tag:', 'attr'=> array('class'=>'form-control')))
            ->add('file', FileType::class,  array('label' => 'Votre Fichier:', 'attr'=> array('class'=>'form-control-file')))
            ->add('bigdescription', TextType::class,  array('label' => 'Description:', 'attr'=> array('class'=>'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Envoyer', 'attr'=> array('class'=>'btn btn-primary')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $insertUser = $odb -> prepare("INSERT INTO `ressources`(`id`, `Name`, `Version`, `Tag`, `Description`) VALUES (NULL, :name, :version, :tag, :description)");
            $insertUser -> execute(array(':name' => $form['name']->getData(), ':tag' => $form['description']->getData(), ':version' => $form['version']->getData(), ':description' => $form['bigdescription']->getData()));
        }

        return $this->render('ressources/posteressource.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}