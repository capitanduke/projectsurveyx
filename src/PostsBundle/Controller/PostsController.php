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
        $posts = $em->getRepository('ModelBundle:Post')->findAll();
        

        return $this->render('PostsBundle:Post:posts.html.twig', array(
            'posts' => $posts,
            
        ));
    }

    /**
     * @Route("/show/{id}", name="showPost")
     */
    public function showPost(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('ModelBundle:Post')->findOneBy(array('id' => $id ));

        $userLogged = $this->get('security.token_storage')->getToken()->getUser();
        $postsUserLogged = $em->getRepository('ModelBundle:Post')->findBy(array('userId' => $userLogged->getId() ));

        //var_dump($postsUserLogged);die;
        //var_dump($post->getUserId());die;


        return $this->render('PostsBundle:Post:showPost.html.twig', array(
            'post' => $post, 'postsUserLogged' => $postsUserLogged, 'userPost' => $post->getUserId()
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
        $post->setTitlePost($request->request->get('postTitle'));



        /* IMAGE */
        if($post->getPath() == null){
            $dir = $this->getParameter('upload_directory');
            $name = uniqid() . '.jpeg';
            $avatar = true;
            foreach ($request->files as $uploadedFile) {
                if ($uploadedFile != null) {
                    $uploadedFile->move($dir, $name);
                } else {
                    $avatar = false;
                }
            }
        }else{
            $dir = $this->getParameter('upload_directory');
            $name = $post->getPath();
            $avatar = false;
            foreach ($request->files as $uploadedFile) {
                if ($uploadedFile != null) {
                    $uploadedFile->move($dir, $name);
                } else {
                    $avatar = false;
                }
            }
        }

        if ($avatar) {
            $post->setPath($name);
        }
        
        
        $em->persist($post);
        $em->flush();
        $response = array("code" => 100, "success" => true );
        $response = new Response(json_encode($response));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

        
    }


    /**
     * @Route("/showModalEditPostAction/{id}", name="showModalEditPostAction")
     * Method({"GET", "POST"})
     * @param Request $request
     * @return View
     */
    public function showModalEditPostAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $poster = $em->getRepository('ModelBundle:Post')->findOneBy(array('id' => $id ));

        $id = $poster->getId();


        return $this->render('PostsBundle:Ajax:editPost.html.twig', array(
            'poster' => $poster, 'id' => $id
        ));
    }

    /**
     * @Route("/editPostAction", name="editPostAction")
     * Method({"GET", "POST"})
     */
    public function editPostAction(Request $request) {


        $em = $this->getDoctrine()->getManager();
        
        $post = $em->getRepository('ModelBundle:Post')->find($request->request->get('postId'));


        Try {

            if($post->getTitlePost() != $post->setTitlePost($request->request->get('postTitle'))){
                $post->setTitlePost($request->request->get('postTitle'));
            }

            if($post->getPostText() != $post->setPostText($request->request->get('postText'))){
                $post->setPostText($request->request->get('postText'));
            }

            
            if($post->getPath() == null){
                $dir = $this->getParameter('upload_directory');
                $name = uniqid() . '.jpeg';
                $avatar = true;
                foreach ($request->files as $uploadedFile) {
                    if ($uploadedFile != null) {
                        $uploadedFile->move($dir, $name);
                    } else {
                        $avatar = false;
                    }
                }
            }else{
                $dir = $this->getParameter('upload_directory');
                $name = $post->getPath();
                $avatar = false;
                foreach ($request->files as $uploadedFile) {
                    if ($uploadedFile != null) {
                        $uploadedFile->move($dir, $name);
                    } else {
                        $avatar = false;
                    }
                }
            }

            if ($avatar) {
                $post->setPath($name);
            }


            $em->persist($post);
            $em->flush();

            $response = array("code" => 100, "success" => true);
            $response = new Response(json_encode($response));
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        } Catch(Exception $e){
            $response = array("code" => 100, "success" => false, "error" => $e);
            return new Response($response);
        }
        
    }



    /**
     * @Route("/deletePostAction", name="deletePostAction")
     * Method({"GET", "POST"})
     */
    public function deletePostAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $postToDelete = $em->getRepository('ModelBundle:Post')->find($request->request->get('postId'));

        $posts = $em->getRepository('ModelBundle:Post')->findAll();


        Try {

            $em->remove($postToDelete);
            $em->flush();


            $response = array("code" => 100, "success" => true);
            $response = new Response(json_encode($response));
            $response->headers->set('Content-Type', 'application/json');

        } Catch(Exception $e){
            $response = array("code" => 100, "success" => false, "error" => $e);
            return new Response($response);
        }


        return $this->render('PostsBundle:Post:posts.html.twig', array(
            'posts' => $posts,
            
        ));
        
        
    }



    


}

?>