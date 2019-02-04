<?php
namespace AppBundle\Repository;


use AppBundle\Entity\Images;
use Doctrine\ORM\EntityRepository;

class ImgJoinRepository extends EntityRepository
{
    public function joinImg(Images $imageid)
    {
        return $imageid->getImgname();
    }
}