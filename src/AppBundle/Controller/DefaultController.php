<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Userinformations ;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
            $em = $this->getDoctrine()->getManager();
            $userinformations = new userinformations();
            $user=$this->getUser();
            $repository = $this->getDoctrine()->getRepository(userinformations::class);
            $userinformations = $repository->findOneBy(['user' => $user]);
            
            
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig',array('userinformations' => $userinformations ));
    }
}
