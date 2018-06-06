<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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

        return new Response('Saved new user with Id '.$user->getId().$this->redirectToRoute('index'));
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
            $session = new Session();
            $session->set('Id', $user->getId());
            $session->set('username', $user->getUsername());
            $session->set('email', $user->getEmail());
            return new Response('Check that out, your Username is: '.$user->getUsername(). '<br> Your Id is:'.$user->getId().'<br>Password verified<br>Remind me:'.$remember);
        }
        else{
            die('Wrong PSW');
        }
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {   
        $session = $this->get('session');
        dump($session);
        $session->remove('email');
        $session->remove('Id');
        return new Response('Session deleted');
    }
}
