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
        else{
            $password=$request->query->get('password');
            $password_val=$request->query->get('password_validation');
            $user=$request->query->get('username');
            $email=$request->query->get('email');
        }
        $entityManager->flush();
        if(strlen($user) <= 20){
            $verifed=true;
        }
        else{
            return new Response('Username can not be longer then 20');
        }
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $verified=true;
        }
        else{
            return new Response('Email '.$email.' not verified');
        }
        if(strlen($password) > 8){
            $verifed=true;
        }
        else{
            return new Response('Password must be at least 8 chars long');
        }
        if($password==$password_val){
            $verified=true;
        }
        else{
            return new Response('Password different to password validation');
        }
        if($verified == true and strlen($user) <= 20 and strlen($password) >= 8 and filter_var($email, FILTER_VALIDATE_EMAIL) and $password==$password_val){
        $user = new User();
        $psw=$this->hashPassword($password, PASSWORD_BCRYPT);
        $user->setUsername($username);
        $user->setPassword($psw);
        $user->setEmail($email);

        // tell Doctrine you want to (eventually) save the user (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT request)
        $entityManager->flush();

        return new Response('Saved new user with Id '.$user->getId().$this->redirectToRoute('index'));
        }
        else{
            return new Response('Username max: 20 Chars <br>
            Email valid email format <br>
            Password min: 8 Chars<br>Re-Type wrong');
        }
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
        if($this->get('session')->has('username')){
            return new Response ('Allready logedin');
        }
        else{
            return $this->render('user/login.html.twig', [
                'controller_name' => 'Login',
            ]);
        }
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
        if ($user and password_verify($password, $user->getPassword())){
                $session = new Session();
                $session->set('Id', $user->getId());
                $session->set('username', $user->getUsername());
                $session->set('email', $user->getEmail());
                return new Response('Check that out, your Username is: '.$user->getUsername(). '<br> Your Id is:'.$user->getId().'<br>Password verified<br>Remind me:'.$remember);
        }
        else{
            die('Wrong Password or Username');
        }
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {   
        $session = $this->get('session');
        $session->remove('username');
        $session->remove('email');
        $session->remove('id');
        return new Response('Session deleted');
    }
}
