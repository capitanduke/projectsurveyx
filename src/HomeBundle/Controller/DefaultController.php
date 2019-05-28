<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('HomeBundle:Default:index.html.twig');
    }

    /**
     * @Route("/loadMenu", name="loadMenu")
     */
    public function loadMenuAction()
    {
        return $this->render('HomeBundle:Ajax:menu.html.twig');
    }
}
