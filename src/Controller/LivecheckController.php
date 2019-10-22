<?php

namespace App\Controller;

use App\Entity\ValidateStatus;
use App\Form\ControlFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LivecheckController extends AbstractController
{
    /**
     * @Route("/", name="livecheck")
     */
    public function index(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(ValidateStatus::class);
        
        if(empty($repo->find(1))){
            $initcheck = new ValidateStatus();
            $em->persist($initcheck);
            $em->flush();
            $firstcheck = $repo->find(1);
        }else{
            $firstcheck = $repo->find(1);
        }
        

        $form = $this->createForm(ControlFormType::class, $firstcheck);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
        }
        
        return $this->render('livecheck/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/check", name="livecheckprobe")
     */
    public function checkAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(ValidateStatus::class);
        if(empty($repo->find(1))|| !$repo->find(1)->getCheckstatus()){
            $response = new Response();
            $response->setStatusCode(500);
            return $response;
        }else{  
            return $this->render('livecheck/check.html.twig',[
        ]);
        }
    }

    /**
     * @Route("/vars", name="env_var")
     */
    public function getVarsAction(Request $request)
    {         
            return $this->render('livecheck/vars.html.twig', [
                'vars'=> dump($_ENV)            
        ]);
        
    }
}
