<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Images;
use Symfony\Component\Form\FormView;

class ImgExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter("getImgName", [$this, "getImgName"]),
        );
    }

    public function getImgName(Images $imageid)
    {

        return  "webimages/".$imageid->getHashname();
    }
}