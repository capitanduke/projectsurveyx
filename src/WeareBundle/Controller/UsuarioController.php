<?php

namespace WeareBundle\Controller;

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



class UsuarioController extends Controller
{
    /**
     * @Route("/users", name="usersWeare")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ModelBundle:User')->findAll();
        //$usuarios = $em->getRepository('ModelBundle:Usuario')->findAll();
        

        return $this->render('WeareBundle:Usuario:users.html.twig', array(
            'users' => $users,
            
        ));
    }

    /**
     * @Route("/following/", name="followingAction")
     * @param Request $request
     * @return Response
     */
    public function followingAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($request->request->get('idUsuario')); //A seguir

        try{

            $seguidor = $this->get('security.token_storage')->getToken()->getUser(); //YO
            $seguidorExist = $em->getRepository('ModelBundle:Followers')->findOneBy(array('seguidoId' => $user->getId() ));

            if($seguidorExist !== null){
                if($user->getId() !== $seguidorExist->getSeguidoId()){
                    $follower = new Followers();
                    $follower->setUsername($seguidor->getUsername());
                    $follower->setUserId($seguidor->getId());
                    $follower->setSeguidoId($user->getId());
                    $em->persist($follower);
                    $em->flush();
                    $response = array("code" => 100, "success" => true);
                    $response = new Response(json_encode($response));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                    //var_dump("diferente a null");die;
                } else{
                    $response = array("code" => 100, "success" => false, "error" => $e);
                    return new Response($response);
                }
            }
            elseif($seguidorExist === NULL){ 
                $follower = new Followers();
                $follower->setUsername($seguidor->getUsername());
                $follower->setUserId($seguidor->getId());
                $follower->setSeguidoId($user->getId());
                $em->persist($follower);
                $em->flush();
                $response = array("code" => 100, "success" => true);
                $response = new Response(json_encode($response));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
                //var_dump("igual a null");die;
    
            }
            
        }

        Catch(Exception $e)
        {
            $response = array("code" => 100, "success" => false, "error" => $e);
            return new Response($response);
        }

    }

    /**
     * @Route("/show/{id}", name="showUser")
     */
    public function showUser(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->findOneBy(array('id' => $id ));

        $userLogged = $this->get('security.token_storage')->getToken()->getUser();
        
        $usuarioDetails = array(
            'id' => $user->getId(),
        );

        return $this->render('WeareBundle:Usuario:show.html.twig', array(
            'user' => $user, 'usuarioDetails' => $usuarioDetails, 'userlogged' => $userLogged,
        ));
    }

    /**
     * @Route("/showme", name="showMe")
     */
    public function showMe(Request $request)
    {
        
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $userLogged = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('ModelBundle:Post')->findBy(array('userId' => $userLogged->getId() ));


        return $this->render('WeareBundle:Usuario:show.html.twig', array(
            'user' => $user, 'userlogged' => $userLogged, 'posts' => $posts
        ));
    }

    /**
     * @Route("/edit/{id}", name="editUser")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->findOneBy(array('id' => $id ));


        return $this->render('WeareBundle:Usuario:edit.html.twig', array(
            'user' => $user, 
        ));
    }


    /**
     * @Route("/editAction", name="editUserAction")
     * Method({"GET", "POST"})
     */
    public function editAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($request->request->get('idUsuario'));


        Try {

            if($user->getUsername() != $user->setUsername($request->request->get('usernameWeare'))){
                $user->setUsername($request->request->get('usernameWeare'));
            }

            if($user->getName() != $user->setName($request->request->get('nameWeare'))){
                $user->setName($request->request->get('nameWeare'));
            }

            if($user->getLastname() != $user->setLastname($request->request->get('lastnameWeare'))){
                $user->setLastname($request->request->get('lastnameWeare'));
            }

            if($user->getAge() != $user->setAge($request->request->get('ageWeare'))){
                $user->setAge($request->request->get('ageWeare'));
            }

            if($user->getGender() != $user->setGender($request->request->get('genderWeare'))){
                $user->setGender($request->request->get('genderWeare'));
            }

            
            if($user->getPath() == null){
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
                $name = $user->getPath();
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
                $user->setPath($name);
            }


            $em->persist($user);
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


    


}







?>