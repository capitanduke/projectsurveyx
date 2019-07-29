<?php

namespace PostsBundle\Controller;

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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class PostsController extends Controller
{
    /**
    * @Route("/posts", name="posts")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$posts = $em->getRepository('ModelBundle:Posts')->findAll();
        

        return $this->render('PostsBundle:Post:posts.html.twig', array(
            
            
        ));
    }

    /**
     * @Route("/showModalCreatePost/", name="showModalCreatePost")
     * @param Request $request
     * @return View
     */
    public function showModalCreatePostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        



        return $this->render('PostsBundle:Ajax:createPost.html.twig', array(
            
        ));
    }

    /**
     * @Route("/createPost/", name="createPost")
     */
    public function createPostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /*$clasificacion = $em->getRepository('GOCModelBundle:Clasificacion')->findOneBy(array('descripcion' => $request->request->get('selectClasificacion')));
        $competencia = new Competencia();
        $competencia->setDescripcion($request->request->get('CrearCompetenciaMantenimientoDescripcion'));
        $competencia->setClasificacion($clasificacion);
        $competencia->setEnabled($request->request->get('EstadoCompetencia'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($competencia);
        $em->flush();
        $response = array("code" => 100, "success" => true, "id" => $competencia->getId(), "descripcion" => $competencia->getDescripcion());
        $response = new Response(json_encode($response));
        $response->headers->set('Content-Type', 'application/json');
        return $response;*/
    }



    


}







?>