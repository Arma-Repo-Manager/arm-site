<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function register_page()
    {
        return $this->render('user/register.html.twig', [
            'controller_name' => 'Reg',
        ]);
    }
   /**
     * @Route("/register_submit", name="register_submit")
     */
    public function register(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        function hashpsw($password){
            $password = password_hash($password, PASSWORD_BCRYPT);
                return $password;
        }
        $psw=hashpsw($request->query->get('password'));
        $user->setUsername($request->query->get('username'));
        $user->setPassword($psw);
        $user->setEmail($request->query->get('email'));

        // tell Doctrine you want to (eventually) save the user (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT request)
        $entityManager->flush();

        return new Response('Saved new user with uid '.$user->getUid());
    }
    /**
     * @Route("/login", name="login")
     */
    public function login_page()
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'Login',
        ]);
    }
    /**
     * @Route("/login_submit", name="login_submit")
     */
    public function login(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository('App:User')->find($request->query->get('uid'));
        return new Response('Check that out, your Username is: '.$user->getUsername());
    }
}
