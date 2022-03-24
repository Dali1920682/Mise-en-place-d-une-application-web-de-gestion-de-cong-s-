<?php

namespace UserBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User ; 
use AppBundle\Entity\conge;
use AppBundle\Entity\Userinformations ;
use AppBundle\Entity\Typecontrat ; 
use AppBundle\Entity\Typeprofession ; 
use AppBundle\Entity\Clientinformation ; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Absence ; 
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }

    public function demandecongeAction(Request $request){
        $user=$this->getUser();
        if ($request->isMethod('post')) {
        $em = $this->getDoctrine()->getManager();
        $datedepart = str_replace('/', '-', $request->get('datedepart'));
        $dateretour = str_replace('/', '-', $request->get('dateretour'));
        $typec=$request->get('typec');
        //calculer nbr de jour
        $dRetour = new \DateTime($dateretour); 
        $dDepart = new \DateTime($datedepart); 
        $interval = $dRetour->diff($dDepart); 
        $nbjour =$interval->format( "%d jours");
        if ($dDepart >= $dRetour ){
            $this->addFlash("warning", "Something wrong");
        }else{
        $userinformations = $repository = $this->getDoctrine()->getRepository(userinformations::class)->findOneBy (['user' => $user]);
        $userconge=$userinformations->getSoldeconge();
        
            if($userconge>= $nbjour){
                $conge = new conge();
                $conge->setDateDepart(new \DateTime($datedepart));
                $conge->setdateretour(new \DateTime($dateretour));
                $conge->setTypec($typec);
                $conge->setdateDemande(new \DateTime());
                $conge->setDecision("En Attente");
                $conge->setNbjour($nbjour);
                $conge->setUser($user);
                $today= (new \DateTime());
                //var_dump($newdate);die;
                if ($dDepart < $today){
                    $this->addFlash("warning", "Something wrong");
                }else{
                    $this->addFlash('success', "Votre Demande a éte Envoyer ");
                $em->persist($conge);
                $userinformations->setSoldeconge($userconge-$nbjour);
                $em->persist($userinformations);
                $em->flush();
            }
        
        }else{
            $this->addFlash("warning", "Solde Conge Is Over");
        }
        }
        }
        return $this ->render ('@User/Default/demandeconge.html.twig');
        } 

        public function userinformationsAction(Request $request){
            $em = $this->getDoctrine()->getManager();
            $userinformations = new userinformations();
            $user=$this->getUser();
            $repository = $this->getDoctrine()->getRepository(userinformations::class);
            $userinformations = $repository->findOneBy(['user' => $user]);
            
            return $this ->render ('@User/Default/userinformations.html.twig',['userinformations' => $userinformations]);
           
        }
        public function modifieruserinfoAction(Request $request){
            $em = $this->getDoctrine()->getManager();
            $userinformations = new userinformations();
            $user=$this->getUser();
            $repository = $this->getDoctrine()->getRepository(userinformations::class);
            $userinformations = $repository->findOneBy(['user' => $user]);
            if ($request->isMethod('post')) {
                $filename = '';
                $avatar = $request->files->get('avatar');
               
                if ($avatar) {
                        // $dir = $this->get('kernel')->getRootDir() . '/../web/uploads/avatars';
                        // $extention = $avatar->getClientOriginalExtension();
                        // $avatar_name = uniqid() . '.' . $extention;
                        // $avatar->move($dir, $avatar_name);
                        // $filename = 'uploads/avatars/' . $avatar_name;
                        // $userinformations->setPhoto($avatar_name);
                }
                $userinformations->setPhoto('tttt');
                $name=$request->get('Name');
                if($name){
                    $userinformations->setName($name);
                }
                $lastname=$request->get('Lastname');
                if($lastname){
                    $userinformations->setLastname($lastname);
                }
                $email=$request->get('Email');
                if($email){
                    $userinformations->setEmail($email);
                }
                $service=$request->get('service');
                if($service){
                    $userinformations->setService($service);
                }
                $tel=$request->get('Tel');
                if($tel){
                    $userinformations->setTel($tel);
                }
                $cin=$request->get('cin');
                if($cin){
                    $userinformations->setCin($cin);
                }
                $datenaissance=$request->get('datenaissance');
                if($datenaissance){
                    $userinformations->setDatenaissance($datenaissance);
                }
                $Adresse=$request->get('Adresse');
                if($Adresse){
                    $userinformations->setAdresse($Adresse);
                }
    
    
            
                $em->flush();
            }
            return $this ->render ('@User/Default/modifieruserinfo.html.twig',['userinformations' => $userinformations]);
        }

        public function mes_demandesAction(){
            
            $user=$this->getUser();
            $repository = $this->getDoctrine()->getRepository(conge::class);
            $mes = $repository->findBy(['user'=>$user]);

            return $this ->render ('@User/Default/mes_demandes.html.twig',['mes' => $mes]);
       
        }


        public function ajoutuserAction(Request $request) {
        
            $userinformations = new userinformations();
            $user=$this->getUser();
          if ($request->isMethod('post')) {
                $em = $this->getDoctrine()->getManager();
                
                $name = $request->get('name');
                $lastname = $request->get('lastname');
                $email = $request->get('email');
                $datenaissance = $request->get('datenaissance');
                $service = $request->get('service');
                $tel = $request->get('tel');
                $adresse = $request->get('Adresse');
                $cin = $request->get('cin');
               
                $userinformations->setName($name);
                $userinformations->setLastname($lastname);
                $userinformations->setEmail($email);
                $userinformations->setdatenaissance(new \DateTime($datenaissance));
                $userinformations->setService($service);
                $userinformations->setTel($tel);
                $userinformations->setAdresse($adresse);
                $userinformations->setCin($cin);
                $userinformations->setDateAdd(new \DateTime());
                $userinformations->setDateModif(new \DateTime());
                $userinformations->setSoldeconge(26);
                $filename = '';
                $avatar = $request->files->get('avatar');
                if ($avatar) {
                    $dir = $this->get('kernel')->getRootDir() . '/../web/uploads/avatars';
                    $extention = $avatar->getClientOriginalExtension();
                    $avatar_name = uniqid() . '.' . $extention;
                    $avatar->move($dir, $avatar_name);
                    $filename = 'uploads/avatars/' . $avatar_name;
                    
                }
                $userinformations->setPhoto($avatar_name);
                $userinformations->setUser($user);
                $em->persist($userinformations);
                $em->flush();
    
            }
            return $this ->render ('@User/Default/ajout.html.twig');
        } 
        public function ajoutinfoAction(Request $request){
            $em = $this->getDoctrine()->getManager();
            $list = $em->getRepository(User::class)->findAll();
           
           
            $clientinformation= new Clientinformation ; 
            $userinformations = new userinformations ;
            if ($request->isMethod('post')) {
    
            
    
                $userinformations->setName($request->get('name'));
                $userinformations->setLastname( $request->get('lastname'));
                $userinformations->setEmail($request->get('email'));
                $userinformations->setdatenaissance(new \DateTime($request->get('datenaissance')));
                $userinformations->setService($request->get('service'));
                $userinformations->setTel($request->get('tel'));
                $userinformations->setAdresse($request->get('Adresse'));
                $userinformations->setCin($request->get('cin'));
                $userinformations->setDateAdd(new \DateTime());
                $userinformations->setDateModif(new \DateTime());
                $userinformations->setSoldeconge(30);
                $filename = '';
                $avatar = $request->files->get('avatar');
                if ($avatar) {
                    $dir = $this->get('kernel')->getRootDir() . '/../web/uploads/avatars';
                    $extention = $avatar->getClientOriginalExtension();
                    $avatar_name = uniqid() . '.' . $extention;
                    $avatar->move($dir, $avatar_name);
                    $filename = 'uploads/avatars/' . $avatar_name;
                    
                }
                $userinformations->setPhoto($avatar_name);
    
                $list=$request->get('user'); 
                $listt = $em->getRepository(User::class)->findOneBy(['username'=>$request->get('user')]);
                $listt->getId(); 
                $clientinformation->setUser($listt);
                $userinformations->setUser($listt);
               
                
                
                $dateOccupation=$request->get('dot');
                $clientinformation->setDateoc(new \DateTime($dateOccupation));
                
                
                
                $em->persist($userinformations);
                $em->persist($clientinformation);
            }
            $em->flush() ; 
           
        return $this ->render ('@User/Default/ajoutinfo.html.twig',array('list' => $list ,));
       
        
         
    }
        public function absenceuserAction(){
                $em=$this->getDoctrine()->getManager();
                $user=$this->getUser();
                $absence_list =$repository = $this->getDoctrine()->getRepository(Absence::class)->findBy (['user' => $user]);
            
                return $this->render ('@User/Default/showabsence.html.twig',['absence_list'=>$absence_list]);
            
        }
    }

