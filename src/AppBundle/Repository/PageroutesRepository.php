<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Pageroutes;
use AppBundle\Entity\Userranks;
use AppBundle\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class PageroutesRepository
 * @package AppBundle\Repository
 */
class PageroutesRepository extends EntityRepository
{

    private $routes = [];

    /**
     * @param Users $users
     * @return array
     */
    public function findUserRoutes(Users $users)
    {

        $em = $this->getEntityManager();

        $q1 = $em
            ->createQuery(
                "SELECT b.rankid, a.routeid, a.routename
                FROM AppBundle:Pageroutes a
                LEft Join a.rankid b
                WHERE   b.rankid = :rankid"
            )
            ->setParameter("rankid", $users->getRankid())
            ->getResult();

        $q2 = $em
            ->createQuery(
                "SELECT identity(a.rankid) as rankid, b.routeid, b.routename
                FROM AppBundle:Users a
                join a.routeid b"
            )
            ->getResult();

       return array_map(
            function($arr) {
                    return ["routeid" => $arr["routeid"], "routename" => $arr["routename"]];
                },
            array_merge($q1, $q2)
        );

    }

    /**
     * @param Users $users
     * @param $string
     * @return array
     */
    public function findPageroutesRankRoute(Users $users, $string)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT u
                FROM AppBundle:Userranks u
                LEft Join u.routeid r
                WHERE   u.rankid = :rankid
                And r.routename = :routename"
            )
            ->setParameter("rankid", $users->getRankid())
            ->setParameter("routename", $string)
            ->getArrayResult();
    }

    /**
     * @param Users $users
     * @param $string
     * @return array
     */
    public function findUserranksRankRoute(Users $users, $string)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT u
                FROM AppBundle:Users u
                LEft Join u.routeid r
                WHERE   u.userid = :userid
                And r.routename = :routename"
            )
            ->setParameter("userid", $users->getUserid())
            ->setParameter("routename", $string)
            ->getArrayResult();
    }
    /**
     * @param Users $users
     * @param Request $request
     * @return array
     */
    public function compareUserRoutes(Users $users, Request $request)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT a
                FROM AppBundle:AccountRoutes a
                WHERE   a.rankid = :rankid
                And a.routename = :routename"
            )
            ->setParameter("rankid", $users->getRankid())
            ->setParameter("routename", $request->attributes->get("_route"))
            ->getArrayResult();
    }
    public function findParentUserRoute($routename, Users $users)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT a
                FROM AppBundle:AccountRoutes a
                WHERE   a.routename = :routename
                And a.rankid = :rankid"
            )
            ->setParameter("routename", $routename)
            ->setParameter("rankid", $users->getRankid())
            ->getArrayResult();
    }

    /**
     * @param Users $users
     * @param $string
     * @return array
     */
    public function compareEntityPageRoutes($string)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT a
                FROM AppBundle:Pageroutes a
                WHERE a.routename = :routename"
            )
            ->setParameter("routename", $string)
            ->getResult();
    }
    public function compareEntityRankRoutes(Pageroutes $pageroutes)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT a
                FROM AppBundle:Userranks a
                LEFT JOIN a.routeid b
                WHERE b.routeid = :routeid"
            )
            ->setParameter("routeid", $pageroutes->getRouteid())
            ->getResult();
    }

    public function findPageRouteRoutePriviliges($routeid){
        return $this->getEntityManager()
            ->createQuery(
                "SELECT p
                FROM AppBundle:Pageroutes p
                LEft Join p.rankid a
                WHERE   a.rankid = :rankid"
            )
            ->setParameter("rankid", $routeid)
            ->getArrayResult();
    }
    public function getAllPageRoutes(){
        return $this->getEntityManager()
            ->createQuery(
                "SELECT p
                FROM AppBundle:Pageroutes p"
            )
            ->getArrayResult();
    }
}