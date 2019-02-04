<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-06-21
 * Time: 20:27
 */

namespace AppBundle\Service;


use AppBundle\Entity\Accountroutes;
use AppBundle\Entity\Pageroutes;
use AppBundle\Entity\Userranks;
use AppBundle\Entity\Users;
use AppBundle\Repository\AccountroutesRepository;
use AppBundle\Repository\PageroutesRepository;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RequestStack;


class UsersService
{
    private $actualRequestRoute = null;
    public function __construct(RequestStack $request){

        $this->actualRequestRoute = $request->getMasterRequest()->attributes->get('_route');

    }

    /**
     * @param PageroutesRepository $pageroutesRepository
     * @param Users $user
     * @return array
     */
    public function createLoggedUserMenu($dataclass, Users $users)
    {


        if($dataclass instanceof EntityRepository) {
            $data = $this->unsetarrayduplicates($dataclass->findUserRoutes($users), "routename");
        }
        else{
            throw new Exception("No repository class in UsersService!!");
        }
        return $this->createMenuFromRouteNames($data, ["userOb" => $users]);
    }

    /**
     * @param array $data
     * @param null $additionalParams
     * @return array
     */
    public function createMenuFromRouteNames(array $data, $additionalParams = null){
        $pages = [];
        $settings = [];

        $pagelink = null;
        $settingslink = null;

        foreach($data as $iterate => $arraydata)
        {
            $rname = $arraydata["routename"];
            $rid = $arraydata["routeid"];

            switch ($rname)
            {
                case 'admin_index':
                    $pagelink = ["name" => "Statystyki","id" => $rid, "route" => $rname];
                    break;
                case 'admin_edit_homepage':
                    $pagelink = ["name" => "Home", "id" => $rid, "route" => $rname];
                    break;
                case 'admin_edit_offerpage':
                    $pagelink = ["name" => "Oferta","id" => $rid,  "route" => $rname];
                    break;
                case 'admin_edit_menupage':
                    $pagelink = ["name" => "Menu", "id" => $rid,"route" => $rname];
                    break;
                case 'admin_edit_newspage':
                    $pagelink = ["name" => "Aktualności", "id" => $rid, "route" => $rname];
                    break;
                case 'admin_edit_contactpage':
                    $pagelink = ["name" => "Kontakt", "id" => $rid, "route" => $rname];
                    break;
                case 'admin_images_show':
                    $settingslink = ["name" => "Zdjęcia", "id" => $rid, "route" => $rname];
                    break;
                case 'admin_route_actualise':
                    $settingslink = ["name" => "aktualizuj menu", "id" => $rid, "route" => $rname];
                    break;
                case 'admin_edit_userspage':
                    $settingslink = ["name" => "Użytkownicy", "id" => $rid, "route" => $rname];
                    break;
                case 'admin_edit_userprofile':
                    $settingslink = ["name" => "Edytuj profil", "id" => $rid, "route" => $rname, "idattribute" => $additionalParams['userOb']->getUserid()];
                    break;
                case 'admin_show_customermessages':
                    $settingslink = ["name" => "Wiadomości klientów", "id" => $rid, "route" => $rname];
                    break;
                case 'admin_userranks_show':
                    $settingslink = ["name" => "Rangi użytkowników", "id" => $rid, "route" => $rname];
                    break;
            }
            if($rname == $pagelink['route']) {
                $pagelink["requestRoute"] = $this->actualRequestRoute;
                $pages[] = $pagelink;
            }
            else if ($rname == $settingslink['route']){
                $settingslink["requestRoute"] = $this->actualRequestRoute;
                $settings[] = $settingslink;
            }
            else if (($rname != $pagelink['route']) && ($rname != $settingslink['route'])){

                throw new Exception("undefinied UserService menu routename");
            }
        }
        return ["pages" => $pages, "settings" => $settings];
    }
    private function unsetarrayduplicates(array $array, string $key)
    {
        $artab = [];
        foreach ($array as $iterate => $arraydata)
        {

            if(in_array($array[$iterate][$key], $artab))
            {
                unset($array[$iterate]);
            }
            else{
                $artab[] = $array[$iterate][$key];
            }

        }

        return $array;
    }
}