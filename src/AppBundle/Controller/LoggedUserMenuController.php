<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-07-01
 * Time: 10:58
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Accountroutes;
use AppBundle\Entity\Pageroutes;
use AppBundle\Repository\PageroutesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;


class LoggedUserMenuController extends Controller
{
    public function __construct()
    {

    }
    public function showUserMenuAction()
    {
        $getUserEntityMenu = $this->getDoctrine()->getRepository(Pageroutes::class);
        $createUserMenu = $this->get('app.userservice')-> createLoggedUserMenu($getUserEntityMenu, $this->getUser());



        return $this->render("Catering/Admin/adminmenu.html.twig",
            [
                "loggeduserentityroutes" => $createUserMenu,
                "current_route" => '',
            ]);
    }
}