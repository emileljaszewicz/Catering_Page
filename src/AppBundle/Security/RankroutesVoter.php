<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 23.09.2018
 * Time: 19:54
 */

namespace AppBundle\Security;


use AppBundle\Entity\Pageroutes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RankroutesVoter extends Voter
{

    const EDIT   = 'edit';

    private $entityManager;
    private $request;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {

        $this->entityManager = $entityManager;
        $this->request = $requestStack->getCurrentRequest()->attributes->get('_route');
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::EDIT))) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        //get current user
        $user = $token->getUser();

        //get repository
        $pageroutes = $this->entityManager->getRepository(Pageroutes::class);

        //check that logged user rank is granted to actual request route
        $findroute = $pageroutes->findPageroutesRankRoute($user, $this->request);

        //check that logged user id is granted to actual request route
        $finduserroute = $pageroutes->findUserranksRankRoute($user, $this->request);

        $getPageroutesData = null;

        foreach ($findroute as $permitedroute){
            if($user->getRankid()->getRankid() == $permitedroute["rankid"]){
                $getPageroutesData = true;
            }
        }
        foreach ($finduserroute as $permiteduserdata){
            if($user->getUserid() == $permiteduserdata["userid"]){
                $getPageroutesData = true;
            }
        }

        switch ($attribute) {
            case self::EDIT:
//                // if the user rank is granted to pageroute allow them to edit page
                if($getPageroutesData === true){
                    return true;
                }
                return false;
                break;
        }

       return true;
    }

}