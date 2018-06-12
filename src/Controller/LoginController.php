<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('login/login.html.twig', [
            'controller_name' => 'Login Page',
        ]);
    }
}
