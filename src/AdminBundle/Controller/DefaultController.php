<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response ;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User ; 
use AppBundle\Entity\conge;
use AppBundle\Entity\Userinformations ;
use AppBundle\Entity\Typecontrat ; 
use AppBundle\Entity\Typeprofession ; 
use AppBundle\Entity\Clientinformation ; 
use AppBundle\Entity\Absence ; 
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    public function listeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $personals_list = $em->getRepository(userinformations::class)->findAll();
        $info_liste = $em->getRepository(Clientinformation::class)->findAll();
        $list = $em->getRepository(User::class)->findAll();
        $type_contrat=$em->getRepository(Typecontrat::class)->findAll();
        $type_profession=$em->getRepository(Typeprofession::class)->findAll();
        $userinformations = new userinformations();
        $inf=$em->getRepository(User::class)->findOneBy(['username'=>$request->get('user')]);
        $userinformations = $em->getRepository(userinformations::class)->findOneBy(['user' =>  $inf]);
        if ($request->isMethod('post')) {
           
           

            $listt = $em->getRepository(User::class)->findOneBy(['username'=>$request->get('user')]);
            $var=$listt->getId();
            
            $clientinformation= $em->getRepository(clientinformation::class)->findOneBy(['user' =>  $var]);
             $id=$clientinformation->getId();
            
            //var_dump($userinformations);die;
             $contrat=$request->get('contrat_type'); 
             $type=$em->getRepository(Typecontrat::class)->findOneBy(['contrat'=>$request->get('contrat_type')]);
             $type->getId();
             $clientinformation->setTypecontrat($type);
           
            $dateOccupation=$request->get('dot');
            $clientinformation->setDateoc(new \DateTime($dateOccupation));
            
            $profession=$request->get('Profession');
            $typep=$em->getRepository(Typeprofession::class)->findOneBy(['profession'=>$request->get('Profession')]);
            $typep->getId();
            $clientinformation->setTypeprofession($typep);
           
        }
        $em->flush() ; 

        return $this ->render ('@Admin/Default/liste.html.twig',array('personals_list' => $personals_list ,"list"=>$list, 'info_liste'=>$info_liste ,'type_contrat'=>$type_contrat ,'type_profession'=>$type_profession,'userinformations' => $userinformations ) );
    }

    public function ajoutAction(Request $request) {
        
        $userinformations = new userinformations();
        $user=$this->getUser();
      if ($request->isMethod('post')) {
            $em = $this->getDoctrine()->getManager();
            
           
           
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
            $userinformations->setUser($user);
            $em->persist($userinformations);
            $em->flush();

        }
        return $this ->render ('@Admin/Default/ajout.html.twig');
    } 

    public function liste_demandeAction(Request $request ){
        $em = $this->getDoctrine()->getManager();
        $demande_list = $em->getRepository(conge::class)->findAll();
        $conge= new conge ; 
        $userinformations = new userinformations ;
        $user=$this->getUser();
        if ($request->isMethod('post')) {
            $dec= $em->getRepository(conge::class)->findOneBy(['id' => $request->get('conge_id')]);
            $ut= $dec->getUser();
            $userinformations = $repository = $this->getDoctrine()->getRepository(userinformations::class)->findOneBy (['user' => $ut]);
            //var_dump($request->get('conge_id'));die;
            $dec->setDecision($request->get('decision'));
              if ($request->get('decision')=='Refuser'){
                $nb=$dec->getNbjour();
                $userconge=$userinformations->getSoldeconge();
                $userinformations->setSoldeconge($userconge + $nb);
                $em->persist($userinformations);
            }
        }
        $em->flush();
           return $this ->render ('@Admin/Default/liste_demande.html.twig',['demande_list' => $demande_list] );
       }
    
    public function admininformationsAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $userinformations = new userinformations();
        $user=$this->getUser();
        $repository = $this->getDoctrine()->getRepository(userinformations::class);
        $userinformations = $repository->findOneBy(['user' => $user]);
        
        
        return $this ->render ('@Admin/Default/admininformations.html.twig',['userinformations' => $userinformations]);
        
    }

    public function modifieradmininfoAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $userinformations = new userinformations();
        $user=$this->getUser();
        $repository = $this->getDoctrine()->getRepository(userinformations::class);
        $userinformations = $repository->findOneBy(['user' => $user]);
        if ($request->isMethod('post')) {

            $filename = '';
            $avatar = $request->files->get('avatar');
                if ($avatar) {
                    $dir = $this->get('kernel')->getRootDir() . '/../web/uploads/avatars';
                    $extention = $avatar->getClientOriginalExtension();
                    $avatar_name = uniqid() . '.' . $extention;
                    $avatar->move($dir, $avatar_name);
                    $filename = 'uploads/avatars/' . $avatar_name;
                    $userinformations->setPhoto($avatar_name);

            }
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
        return $this ->render ('@Admin/Default/modifieradmininfo.html.twig',['userinformations' => $userinformations]);
    }
public function modifieruserAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository(User::class)->findAll();
        $type_contrat=$em->getRepository(Typecontrat::class)->findAll();
        $type_profession=$em->getRepository(Typeprofession::class)->findAll();
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
            $contrat=$request->get('contrat_type'); 
            $type=$em->getRepository(Typecontrat::class)->findOneBy(['contrat'=>$request->get('contrat_type')]);
            //$type->getId();
            $clientinformation->setTypecontrat($type);
            
            $dateOccupation=$request->get('dot');
            $clientinformation->setDateoc(new \DateTime($dateOccupation));
            
            $profession=$request->get('Profession');
            $typep=$em->getRepository(Typeprofession::class)->findOneBy(['profession'=>$request->get('Profession')]);
            //$typep->getId();
            $clientinformation->setTypeprofession($typep);
            
            $em->persist($userinformations);
            $em->persist($clientinformation);
        }
        $em->flush() ; 
       
    return $this ->render ('@Admin/Default/modifieruser.html.twig',array('list' => $list ,'type_contrat'=>$type_contrat ,'type_profession'=>$type_profession));
   
    
     
}
public function absenceAction(Request $request){
    $em=$this->getDoctrine()->getManager();
    $user_list = $em->getRepository(User::class)->findAll();
    $error ="";
   
    
    if ($request->isMethod('post')) {
        $Absence = new Absence ;
       $user= $em->getRepository(User::class)->findOneBy(['username'=>$request->get('user')]);
       $today = new \DateTime();
       /* test if existe absence of this user */
       $has_marqued_absent = $em->getRepository(Absence::class)->findBy(['user' => $user, 'date' => $today]);
       //echo '<pre>';
       if($has_marqued_absent){
        $error = "Vous avez dèjà marquer cet utilisateur absent !";
       }else{
        
        $this->addFlash('success', "L'absence a été enregistrée");
            //$user->getId(); 
            $Absence->setUser($user);
            $Absence->setDate($today);
            $conge=$em->getRepository(conge::class)->findOneBy(['user' => $user]);
            /*if ($conge != null){
                $test=$today >= $conge->getDatedepart() & $today <= $conge->getDateretour() & $conge->getDecision() == 'Accepter';
                var_dump($conge->getDecision());die;
                if ($test){
                    echo "yes" ; 
                }
            }*/
            
            //if ($request->get('absent') == 'on' ){
                $Absence->setEtatAbsence('Absent');
            //}
            $em->persist($Absence);
            $em->flush();
            
        }
        
    }
    return $this ->render ('@Admin/Default/absence.html.twig',array('user_list' =>$user_list ,'error'=>$error ));
   }
    public function show_absenceAction(){
        $em=$this->getDoctrine()->getManager();
        $absence_list = $em->getRepository(Absence::class)->findAll();



        return $this->render ('@Admin/Default/showabsence.html.twig',['absence_list'=>$absence_list]);
    }

    public function modifierlisteAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(clientinformation::class)->findAll();
        $list = $em->getRepository(User::class)->findAll();
        $type_contrat=$em->getRepository(Typecontrat::class)->findAll();
        $type_profession=$em->getRepository(Typeprofession::class)->findAll();
        $clientinformation= new Clientinformation ; 

        
           
                 
           
        if ($request->isMethod('post')) {
            $listt = $em->getRepository(User::class)->findOneBy(['username'=>$request->get('user')]);
        $var=$listt->getId();

            $clientinformation= $em->getRepository(clientinformation::class)->findOneBy(['user' =>  $var]);
             $id=$clientinformation->getId();

            
             $contrat=$request->get('contrat_type'); 
             $type=$em->getRepository(Typecontrat::class)->findOneBy(['contrat'=>$request->get('contrat_type')]);
             $type->getId();
             $clientinformation->setTypecontrat($type);
           
            $dateOccupation=$request->get('dot');
            $clientinformation->setDateoc(new \DateTime($dateOccupation));
            
            $profession=$request->get('Profession');
            $typep=$em->getRepository(Typeprofession::class)->findOneBy(['profession'=>$request->get('Profession')]);
            $typep->getId();
            $clientinformation->setTypeprofession($typep);
           
        }
        $em->flush() ; 

        return $this->render ('@Admin/Default/modifierliste.html.twig',array('list' => $list ,'type_contrat'=>$type_contrat ,'type_profession'=>$type_profession));
   
    }
}
