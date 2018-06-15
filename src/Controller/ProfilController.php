<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfilController extends Controller
{
  
    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request)
    {
        $session = $this->get('session');
        if($session->has('username')){
            $username=$session->get('username');
            return $this->render('user/profil.html.twig', [
                'controller_name' => 'Profil',
                'username' => $username
            ]);
        }
        else{
            return new Response('Not loged in');
        }
    }
}
