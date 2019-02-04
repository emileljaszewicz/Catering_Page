<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-06-28
 * Time: 22:17
 */

namespace AppBundle\Service;


use AppBundle\Entity\Users;
use AppBundle\Exception\DoubleEntityCellException;
use AppBundle\Repository\AccountroutesRepository;
use Symfony\Component\HttpFoundation\Request;

class AccountroutesService
{
    public function compareUserRoutes(Users $users, AccountroutesRepository $accountroutesRepository, Request $request)
    {

        if(sizeof($accountroutesRepository->compareUserRoutes($users, $request)) == 1)
        {
            return true;
        }
        if(sizeof($accountroutesRepository->compareUserRoutes($users, $request)) > 1){
            throw new DoubleEntityCellException("To much Entity routes!! Some entity routes already exists");
        }

        return false;
    }

    public function parentRoutePermissions($routename, Users $users, AccountroutesRepository $accountroutesRepository)
    {
        if(sizeof($accountroutesRepository->findParentUserRoute($routename, $users)) == 1)
        {
            return true;
        }

        return false;
    }
    public function createLoggedUserMenu(AccountroutesRepository $accountroutesRepository)
    {
        return  'moje menu';
    }
}