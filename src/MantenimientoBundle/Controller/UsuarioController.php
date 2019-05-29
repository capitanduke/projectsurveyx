<?php

namespace MantenimientoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ModelBundle\Entity\User;
use ModelBundle\Entity\Usuario;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;


class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios", name="usuariosMantenimiento")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ModelBundle:User')->findAll();
        $usuarios = $em->getRepository('ModelBundle:Usuario')->findAll();
        

        return $this->render('MantenimientoBundle:Usuario:usuario.html.twig', array(
            'users' => $users,
            'usuarios' => $usuarios,
        ));
    }


    /**
     * @Route("/show/{id}", name="showUser")
     */
    public function showUser(Request $request, $id)
    {
        
        //var_dump($id);die;
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->findOneBy(array('id' => $id ));
        //$user = $em->getRepository('ModelBundle:User')->findAll();
        


        $usuarioDetails = array(
            'id' => $user->getId(),
        );
        
        

        return $this->render('MantenimientoBundle:Usuario:show.html.twig', array(
            'user' => $user, 'usuarioDetails' => $usuarioDetails,
        ));
    }


}







?>