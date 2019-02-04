<?php
namespace AppBundle\Repository;


use AppBundle\Entity\Pageroutes;
use AppBundle\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;


class UsersRepository extends EntityRepository implements UserLoaderInterface
{

    /**
     * @param string $username
     * @return mixed|null|\Symfony\Component\Security\Core\User\UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findUserRoutes(Users $users)
    {

        $em = $this->getEntityManager();

        $q1 = $em
            ->createQuery(
                "SELECT a.userid, b.routeid, b.routename
                FROM AppBundle:Users a
                Join a.routeid b
                WHERE   a.userid = :userid"
            )
            ->setParameter("userid", $users->getUserid())
            ->getResult();

        return array_map(
        function($arr) {
            return ["routeid" => $arr["routeid"], "routename" => $arr["routename"]]; },
        $q1
    );
    }
    public function findGrantedUserRoute(Users $users, int $routeid)
    {
        $em = $this->getEntityManager();

        return $em
            ->createQuery(
                "SELECT a.userid, b.routeid
                FROM AppBundle:Users a
                Join a.routeid b
                WHERE a.userid = :userid
                AND b.routeid = :routeid"
            )
            ->setParameter("userid", $users->getUserid())
            ->setParameter("routeid", $routeid)
            ->getResult();
    }
}