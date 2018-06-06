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
    public function registerPage()
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

        $username=$request->query->get('username');
        $checkUsername = $entityManager->getRepository('App:User')->findOneBy(array('username'=> $username));
        if($checkUsername){
            return new Response('Username already used');
        }
        $entityManager->flush();

        $user = new User();
        $psw=$this->hashPassword($request->query->get('password'), PASSWORD_BCRYPT);
        $user->setUsername($request->query->get('username'));
        $user->setPassword($psw);
        $user->setEmail($request->query->get('email'));

        // tell Doctrine you want to (eventually) save the user (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT request)
        $entityManager->flush();

        return new Response('Saved new user with uid '.$user->getUid());
    }
    private function hashPassword($password, $algo)
    {
        $passwordHashed=password_hash($password, $algo);
        return $passwordHashed;
    }
    /**
     * @Route("/login", name="login")
     */
    public function loginPage()
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
        $username=$request->query->get('username');
        $password=$request->query->get('password');
        $remember=$request->query->get('remember');
        $user = $entityManager->getRepository('App:User')->findOneBy(array('username'=> $username));
        if(password_verify($password, $user->getPassword())){
            return new Response('Check that out, your Username is: '.$user->getUsername(). '<br> Your UID is:'.$user->getUid().'<br>Password verified<br>Remind me:'.$remember);
        }
        else{
            die('Wrong PSW');
        }
    }
}
