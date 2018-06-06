<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Storage\S3\s3;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Repo;

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
        
        $entityManager = $this->getDoctrine()->getManager();
        $repo = new Repo();

        foreach($request->request->all() as $key => $mod) {
            if($mod !== 'on') {
                $repo->setName($mod);
                $repo->setFolder('test'); //AS_TODO: Fix this when repo-creator-package is finisched
                $repo->setUserId(1);//AS_TODO: Fix this when registration is done!
            }
            $entityManager->persist($repo);
            $entityManager->flush();

            return $this->redirectToRoute('repo', [
                'id' => $repo->getId()
            ]);
        }
        
    }
}
