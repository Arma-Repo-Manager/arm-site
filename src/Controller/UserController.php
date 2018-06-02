<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
   /**
     * @Route("/register", name="register")
     */
    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername($request->query->get('username'));
        $user->setPassword($password);
        $user->setEmail($request->query->get('email'));

        // tell Doctrine you want to (eventually) save the user (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());
    }
}
