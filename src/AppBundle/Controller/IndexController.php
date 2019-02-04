<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Aboutcompany;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $getCompanyInfo = $entityManager->getRepository(Aboutcompany::class);
        $getCompanyDesc = $getCompanyInfo->findAll();


         return $this->render("Catering/index.html.twig",
             [
                 "aboutcompany" => $getCompanyDesc,
             ]);
    }

}