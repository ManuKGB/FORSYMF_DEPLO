<?php

namespace App\Controller;
use App\Entity\Personel;
use App\Repository\PersonelRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\DepartementRepository;
use App\Repository\TypePersoRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\serices\MailService;
use App\serices\MailController;




class PersonelController extends AbstractController
{

    public function __constructor(MailController $mailer)
    {

    }
  //  #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    
    #[Route('/api/admin/personel', name:'Users',methods:['GET'])]
    
    public function index(PersonelRepository $respository,SerializerInterface $serializer):JsonResponse
    {
       $personel=$respository->findBy(
        array('deleted'=>0),
       );
        $result=$serializer->serialize($personel, 'json', ['groups' => 'getPersonel']); 
        return new JsonResponse($result, Response::HTTP_OK, ['accept' => 'json'], true);

        // return $this->json($respository->findAll(), Response::HTTP_OK, [], ['groups'=>'getPersonel']);
    }


    //profilget
    #[Route('/api/admin/personele', name:'Userse',methods:['GET'])]
    
    public function indexe(PersonelRepository $respository,SerializerInterface $serializer):JsonResponse
    {
       $personel=$respository->findBy(
        array('username'=>null),
       );
        $result=$serializer->serialize($personel, 'json', ['groups' => 'getPersonel']); 
        return new JsonResponse($result, Response::HTTP_OK, ['accept' => 'json'], true);

        // return $this->json($respository->findAll(), Response::HTTP_OK, [], ['groups'=>'getPersonel']);
    }
  

    // recuperer un personel avec son id 


    
    #[Route('api/admin/personel/{id}', name: 'detailperso', methods: ['GET'])]

    public function getDetailperso(Personel $personel, SerializerInterface $serializer): JsonResponse 
    {
        if(!$personel->isDeleted()){
            $jsonperso = $serializer->serialize($personel, 'json',['groups'=>'getPersonel']);


        }
        return new JsonResponse($jsonperso, Response::HTTP_OK, ['accept' => 'json'], true);
    }


    //creation d un utilisateur
    /*
  //  #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    #[Route('/api/admin', name:'users_symfony', methods:['POST'])]
    public function creation(Request $request , EntityManagerInterface $em, UserPasswordHasherInterface $hasher,DepartementRepository $departement,PersonelRepository $personel, SerializerInterface $serializer):JsonResponse

    {
        $personel= new Personel();
        $parameter =Json_decode($request->getContent(), true);
       // $idDep=$parameter['idDepartement'] ?? -1;
       // $personel->setDepartement($departement->find($idDep));


        
        $personel->setNom($parameter['nom']);
        $personel->setRoles($parameter['roles']);
        $personel->setPassword($hasher->hashPassword($personel, $parameter['password']));
        $personel->setPrenom($parameter['prenom']);

        $dt=new DateTime();
        $date=$dt->createFromFormat("y-m-d", date("y-m-d", (int) $parameter['date_naissance'] ) );
        $personel->setDateNaissance(($date));
        $personel->setAdresse($parameter['adresse']);
        $personel->setEmail($parameter['email']); 
        $personel->setContact($parameter['contact']); 
        $personel->setDepartement($parameter['departement_id']);
    

        $em->persist($personel);
        $em->flush();

        return $this->Json($personel);
    }*/


    #[Route('/api/admin/personel', name:"createperso", methods: ['POST'])]
    public function createperso(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,DepartementRepository $departementRepository,TypePersoRepository $type,ValidatorInterface $validator): JsonResponse 
    {

        $perso = $serializer->deserialize($request->getContent(), Personel::class, 'json');
        
     
        $content = $request->toArray();
        $errors = $validator->validate($perso);

        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $idDep=$content['idDepartement'] ?? -1;
        $idtyp=$content['IdType'];
        $perso->setDepartement($departementRepository->find($idDep));
        $perso->setTypePerso($type->find($idtyp));
        $perso->setIschef(true);
        $perso->setDeleted(false);
        $em->persist($perso);
        $em->flush();

        $jsonPerso = $serializer->serialize($perso, 'json', ['groups' => 'getPersonel']);

        return new JsonResponse($jsonPerso, Response::HTTP_CREATED,[],true);
   }




// modification d un utilisateur
   // #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    /*#[Route('/api/admin/{id}','users_update', methods:['PUT'])]
    public  function update_users(Request $request, $id,  EntityManagerInterface $em , PersonelRepository $respository,ValidatorInterface $validator,SerializerInterface $serializer): Response

    {
        $data = $respository->find($id);

        $parameter=Json_decode($request->getContent(), true);
        
        $data->setNom($parameter['nom']);
       // $data->setRoles(['ROLE_USER']);
        $data->setPrenom($parameter['prenom']);
        $dt=new DateTime();
        $date=$dt->createFromFormat("y-m-d", date("y-m-d", (int) $parameter['date_naissance'] ) );
        $data->setDateNaissance(($date));
        $data->setAdresse($parameter['adresse']);
        $data->setEmail($parameter['email']); 
        $data->setContact($parameter['contact']); 

        
        $em->persist($data);
        $em->flush();
        return $this->Json($data);
    }*/

    #[Route('/api/admin/{id}', name:"updateBook", methods:['PUT'])]

    public function updatePerso(Request $request, SerializerInterface $serializer, Personel $Perso, EntityManagerInterface $em, DepartementRepository $departementRepository,TypePersoRepository $TypeReposity): JsonResponse 
    {
        $updatedPerso= $serializer->deserialize($request->getContent(), 
                Personel::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $Perso]);
        $content = $request->toArray();
        $idDep=$content['idDepartement'] ?? -1;
        $idtyp=$content['IdType'];
        $Perso->setDepartement($departementRepository->find($idDep));
        $Perso->setTypePerso($TypeReposity->find($idtyp));
        $em->persist($Perso);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }

   
    // effacer un utilisateur
    
    //#[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    #[Route('api/admin/personel/{id}', name: 'deleteperso', methods: ['DELETE'])]

    public function deletedperso(Request $request, SerializerInterface $serializer, Personel $Perso, EntityManagerInterface $em)

    {
        if ($Perso && !$Perso->isDeleted()){
            $Perso->setDeleted(true);
            $em->flush();
            $reuslt=$serializer->serialize($Perso, 'json', ['groups' => 'getPersonel']);
            return new JsonResponse($reuslt, Response::HTTP_OK, ['accept' => 'json'], true);
        } elseif($Perso && $Perso->isDeleted()){
            $x=array(
                "status"=> JsonResponse::HTTP_NOT_FOUND,
                "message"=> "object not found!"
            );
            $err=$serializer->serialize($x,'json' );
            return new JsonResponse($err,JsonResponse::HTTP_NOT_FOUND,[],true);
        }


    }



    //creation de profil
      #[Route('/api/admin/generate/{id}',name:'users_update', methods:['PUT'])]
    public  function personel( EntityManagerInterface $em,UserPasswordHasherInterface $hasher,Personel $personel, MailerInterface $mailer): Response

    {
       $usernname =  $this->random_str(6);
       $password = $this->random_str(6);
       
       $personel->setUsername($usernname);
       $personel->setPassword($hasher->hashPassword($personel, $password));
       $em->flush();
       $message="votre identifant est: ";
       $messagee="votre mot de passe est:  ";
       $mailMessage=$message.''.$personel->getUsername(). '' . $messagee.''.$personel->getPassword();
       $email = (new Email())
            ->from('tunde.binessicr7@gmailCom')
            ->to('caleb.binessi12@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
         return new JsonResponse(['username' => $usernname, 'password' => $password], JsonResponse::HTTP_OK);
    }
    private function random_str($length){
        $random_string="";
        for($i=0;$i<$length;$i++){
            $number=random_int(0,36);
            $character=base_convert($number,10,36);
            $random_string.=$character;
        }
        return $random_string;

    }



//     #[Route('/api/admin/{id}', name:"update", methods:['PUT'])]

//     public function updatePersoo(Request $request, SerializerInterface $serializer, Personel $Perso, EntityManagerInterface $em, DepartementRepository $departementRepository,TypePersoRepository $TypeReposity): JsonResponse 
//     {
//         $updatedPerso= $serializer->deserialize($request->getContent(), 
//                 Personel::class, 
//                 'json', 
//                 [AbstractNormalizer::OBJECT_TO_POPULATE => $Perso]);
//         $content = $request->toArray();
//         $idDep=$content['idDepartement'] ?? -1;
//         $idtyp=$content['IdType'];
//         $Perso->setDepartement($departementRepository->find($idDep));
//         $Perso->setTypePerso($TypeReposity->find($idtyp));
//         $em->persist($Perso);
//         $em->flush();

//         return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
//    }





/*public function sendEmail(MailerInterface $mailer):void {
    $to='caleb.binessi12@gmail.com';
    $content='<p>See Twig integration for better HTML integration!</p>';
    $subject='Time for Symfony Mailer!';
    
    $email = (new Email())
        ->from('tunde.binessicr7@gmail.com')
        ->to($to)
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Time for Symfony Mailer!')
        ->text($subject)
        ->html( $content);

    $mailer->send($email);

    // ...
}*/


#[Route('/api/admin/testee',name:'users_updatee', methods:['GET'])]
public  function personele(  MailerInterface $mailer): Response{

$to='caleb.binessi12@gmail.com';
$content='<p>See Twig integration for better HTML integration!</p>';
$subject='Time for Symfony Mailer!';

{
   $email = (new Email())
        ->from('tunde.binessicr7@gmailCom')
        ->to($to)
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject($subject)
        ->text('Sending emails is fun again!')
        ->html($content);

    $mailer->send($email);
     return new JsonResponse($email, JsonResponse::HTTP_OK);
}
}


// 
// Qu'est ce que tu voulais deja? j'ai forget
//  affecter chef -----------ouvre le controlleur qui fait as 
//oui est la fonction
//c'est maintenant on dois faire ça   on fait quoi dab?-------------- je dois voir d'abord ce que je fais  







}
