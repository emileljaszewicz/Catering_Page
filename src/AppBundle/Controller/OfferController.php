<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Activityrange;
use AppBundle\Entity\Pagedescription;
use AppBundle\Service\ShoppingBasketSrvice;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class OfferController extends Controller
{
    /**
     * @Route("/offer", name="view_offer")
     *
     * @param Request $request
     * @return Response
     */
    public function indexOfferAction(Request $request)
    {
        $basket = new ShoppingBasketSrvice();

        $requests = new RequestStack();
        $eM = $this->getDoctrine()->getManager();
        $pageDescription = $eM->getRepository(Pagedescription::class)->findOneBy(['routename' => $request->attributes->get('_route')]);
        $activityRange = $eM->getRepository(Activityrange::class)->findAll();

        return $this->render("Catering/offer.html.twig", [
            "pageDescription" => $pageDescription,
            "activityRange" => $activityRange,
        ]);
    }
}