<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Storage\S3\s3;
use Symfony\Component\HttpFoundation\Request;

class RepoController extends Controller
{
    /**
     * @Route("/repo", name="repo")
     */
    public function index(Request $request)
    {   
        if($request->getMethod() != 'POST') {
            $s3 = new s3(getenv('AWS_KEY'), getenv('AWS_SECRET'));
            $result = $s3->getAllMods();
            $mods = [];

            foreach($result as $mod) {
                $modArr = explode('/', $mod);
                $mods[] = str_replace('.zip', '',$modArr[count($modArr)-1]);
            }

            return $this->render('repo/index.html.twig', [
                'mods' => $mods,
            ]);
        }

        foreach($result as $mod) {
            
        }
        
    }
}
