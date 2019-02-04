<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-05-31
 * Time: 12:33
 */

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Entity\Pagedescription;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * @Route("/news", name="show_news")
     */
    public function showNewsAction(Request $request)
    {
        $pageInfo = $this->getDoctrine()->getRepository(Pagedescription::class)->findOneBy(['routename' => $request->attributes->get('_route')]);

        $news = $this->getDoctrine()->getRepository(News::class)->findAll();
        return $this->render("Catering/news.html.twig", [
            "pageDescription" => $pageInfo,
            "allNews" => $news,
        ]);
    }
}