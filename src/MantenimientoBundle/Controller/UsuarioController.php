<?php

namespace MantenimientoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ModelBundle\Entity\User;
use ModelBundle\Entity\Categoria;
use ModelBundle\Entity\Followers;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios", name="usuariosMantenimiento")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ModelBundle:User')->findAll();
        //$usuarios = $em->getRepository('ModelBundle:Usuario')->findAll();
        

        return $this->render('MantenimientoBundle:Usuario:usuarios.html.twig', array(
            'users' => $users,
            
        ));
    }

    /**
     * @Route("/following/{id}", name="followingAction")
     */
    public function followingAction(Request $request, $id)
    {
        $follower = new Followers();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->findOneBy(array('id' => $id ));

        //$em = $this->getDoctrine()->getManager();
        $follower = $em->getRepository('ModelBundle:Followers');

        //var_dump($em);die;

        $follower->setUsername();
        $em->getRepository('ModelBundle:Followers')->persist($user);
        $em->flush();

       

        return $this->render('MantenimientoBundle:Usuario:usuarios.html.twig', array(
            'follower' => $follower,
            
        ));
    }

    /**
     * @Route("/show/{id}", name="showUser")
     */
    public function showUser(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->findOneBy(array('id' => $id ));
        
        $usuarioDetails = array(
            'id' => $user->getId(),
        );

        return $this->render('MantenimientoBundle:Usuario:show.html.twig', array(
            'user' => $user, 'usuarioDetails' => $usuarioDetails,
        ));
    }


    /**
     * @Route("/edit/{id}", name="editUser")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        
        $usuario = new Usuario();
        $usuario = $this->getDoctrine()->getRepository('ModelBundle:User')->findOneBy(array('id' => $id ));


        /*var_dump($usuario);die;

        $theUsuario = $theUsuario->getId();
        var_dump($theUsuario);die;
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();*/

        //var_dump($theUsuario);die;

        //var_dump($usuario->setId(2));die;

        //$usuario->setId($id);

        /*$em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();*/

        
        $form = $this->createFormBuilder($usuario)
            ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $usuario = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('usuariosMantenimiento');
        }



        return $this->render('MantenimientoBundle:Usuario:edit.html.twig', array(
          'form' => $form->createView()
        ));
    }


    


}







?>