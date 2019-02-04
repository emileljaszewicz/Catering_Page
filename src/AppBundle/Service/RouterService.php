<?php

namespace AppBundle\Service;


use Symfony\Component\Routing\Router;

class RouterService
{
    /**
     * @var array
     */
    private $symfonyroutes = [];


    public function getRouterRoutes(Router $router)
    {

        $routerCollection = $router->getRouteCollection();

        foreach($routerCollection as $routename => $value)
        {

            $this->symfonyroutes[$routename] = $routerCollection->get($routename)->getPath();
        }

        return $this;
    }

    public function filterRoutesByName($search)
    {
        if(is_array($this->symfonyroutes))
        {
            foreach ($this->symfonyroutes as $name => $url)
            {

                if(strpos($name, $search) === false)
                {
                    unset($this->symfonyroutes[$name]);
                }
            }
        }
        else{
            return false;
        }
        return $this->symfonyroutes;
    }

    public function filterRoutesByURL($search)
    {
        if(is_array($this->symfonyroutes))
        {
            foreach ($this->symfonyroutes as $name => $url)
            {

                if(strpos($url, $search) === false)
                {
                    unset($this->symfonyroutes[$name]);
                }
            }
        }
        else{
            return false;
        }
        return $this->symfonyroutes;
    }
    public function showRouteNamesAfter($string)
    {
        if(is_array($this->symfonyroutes))
        {
            foreach ($this->symfonyroutes as $name => $url)
            {
                if(strpos($name, $string) !== false) {
                    $curoutename = substr($name, 0, strlen($string));

                    $this->symfonyroutes[$curoutename] = $url;

                    unset($this->symfonyroutes[$name]);
                }
            }
        }

        return $this->symfonyroutes;
    }
    public function showRouteNamesBefore($string)
    {
        if(is_array($this->symfonyroutes))
        {
            foreach ($this->symfonyroutes as $name => $url)
            {
                if(strpos($name, $string) !== false) {
                    $curoutename = substr($name, strpos($name, $string));

                    $this->symfonyroutes[$curoutename] = $url;

                    unset($this->symfonyroutes[$name]);
                }
            }
        }

        return $this->symfonyroutes;
    }

    public function showRouteUrlsAfter($string)
    {
        if(is_array($this->symfonyroutes))
        {
            foreach ($this->symfonyroutes as $name => $url)
            {
                if(strpos($url, $string) !== false) {
                    $curoutename = substr($url, strlen($string));

                    $this->symfonyroutes[$name] = $curoutename;
                }
            }
        }

        return $this->symfonyroutes;
    }
    public function showRouteUrlsBefore($string)
    {
        if(is_array($this->symfonyroutes))
        {
            foreach ($this->symfonyroutes as $name => $url)
            {
                if(strpos($url, $string) !== false) {
                    $curoutename = substr($url, 0, strpos($url, $string));

                    $this->symfonyroutes[$name] = $curoutename;
                }
            }
        }

        return $this->symfonyroutes;
    }
}