<?php
/**
 * Created by PhpStorm.
 * User: E
 * Date: 2018-06-16
 * Time: 13:25
 */

namespace AppBundle\Twig;


class AccesExtension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction("is_logged",[$this, "checkUserSession"])
        );
    }

    public function checkUserSession($session)
    {
        if(!empty($_SESSION[$session]))
        {
            return true;
        }
    }
}