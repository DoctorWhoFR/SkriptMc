<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ViewRessourceController extends Controller
{

    /**
     * @Route("/viewressource/")
     */

    public function showAction(){
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'skriptmc');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        $odb = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);

        $requete = $odb->prepare("SELECT * FROM ressources");
        $requete->execute();
        $requete -> fetch(\PDO::FETCH_OBJ);

        return $this->render('ressources/viewressource.html.twig', array(
            'skripts' => $requete
        ));
    }



}