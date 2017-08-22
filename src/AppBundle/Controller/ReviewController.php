<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use AppBundle\Entity\Version;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    /**
     * @Route("/{id}/new/review", name="review_new")
     * @param Version $id
     * @param Request $request
     * @return Response
     */

    public function newReviewAction(Version $id = null, Request $request){

        $review = new Review();
        $forms = $this->createForm('AppBundle\Form\ReviewType', $review);
        $forms->handleRequest($request);

        if ($forms->isSubmitted() && $forms->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $review->setVersion($id);
            $em->persist($review);

            $em->flush();

            return $this->redirectToRoute("resources_view", array('id' => $id->getResource()->getId()));
        }

        return $this->render("reviews/new.html.twig", array(
            "forms" => $forms->createView()
        ));

    }

    /**
     * @Route("/{id}/delete/review", name="resource_delete_review")
     * @param Review $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function newDeleteReview(Review $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();

        return $this->redirectToRoute("resources_index");
    }
}
