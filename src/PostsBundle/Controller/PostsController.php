<?php

namespace PostsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ModelBundle\Entity\User;
use ModelBundle\Entity\Categoria;
use ModelBundle\Entity\Followers;
use ModelBundle\Entity\Post;
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

        $currentUser = $this->get('security.token_storage')->getToken()->getUser()->getId();

        return $this->render('PostsBundle:Ajax:createPost.html.twig', array(
            'currentUser' => $currentUser,
        ));
    }

    /**
     * @Route("/createPost/", name="createPost")
     */
    public function createPostAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('ModelBundle:User')->find($request->request->get('currentUser'));

        $post = new Post();
        
        $post->setUserId($user);
        $post->setPostText($request->request->get('postText'));
        
        
        $em->persist($post);
        $em->flush();
        $response = array("code" => 100, "success" => true );
        $response = new Response(json_encode($response));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

        
    }



    


}







?>