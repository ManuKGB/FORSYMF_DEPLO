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
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

use function PHPUnit\Framework\returnSelf;

class PersonelController extends AbstractController
{
  
   // #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
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
  

    // recuperer un personel avec son id 


    
    #[Route('api/admin/personel/{id}', name: 'detailperso', methods: ['GET'])]

    public function getDetailperso(Personel $personel, SerializerInterface $serializer): JsonResponse 
    {
        if(!$personel->isDeleted()){
            $jsonperso = $serializer->serialize($personel, 'json',['groups'=>'getPersonel']);


        }
        return new JsonResponse($jsonperso, Response::HTTP_OK, ['accept' => 'json'], true);
    }

      
    #[Route('api/nom/{username}', name: 'detailpersohy', methods: ['GET'])]

    public function getusernameperso(PersonelRepository  $personel, SerializerInterface $serializer
    , string  $username
    ): JsonResponse 
    {
        $p=$personel->findOneBy(
            array("username"=>$username)
        );
        // if(!$personel->isDeleted()){
        //     $jsonperso = $serializer->serialize($personel, 'json',['groups'=>'getPersonel']);


        // }
        $jsonperso = $serializer->serialize($p, 'json',['groups'=>'getPersonel']);
        return new JsonResponse($jsonperso, Response::HTTP_OK, ['accept' => 'json'],true);
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

   // #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
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
        $perso->setDeleted(false);
        $perso->setMdpChanged(false);
        $perso->setNameChanged(false);

        $em->persist($perso);
        $em->flush();

        $jsonPerso = $serializer->serialize($perso, 'json', ['groups' => 'getPersonel']);

        return new JsonResponse($jsonPerso, Response::HTTP_CREATED);
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

    #[Route('/api/update/{id}', name:"updateBook", methods:['PUT'])]

    public function updatePerso(Request $request, int $id, SerializerInterface $serializer, Personel $personel, EntityManagerInterface $em, PersonelRepository  $personelRepository, DepartementRepository $departementRepository,TypePersoRepository $TypeReposity , UserPasswordHasherInterface $hasher): JsonResponse 
    {
        $parameter = Json_decode($request->getContent(), true);

        if (array_key_exists('password', $parameter) && $parameter['password'] != null && trim($parameter['password']) != '') {
            $personel->setPassword($hasher->hashPassword($personel, trim($parameter['password'])));
            $personel->setMdpChanged(true);
        }

        if (  array_key_exists('username', $parameter)  &&  $parameter['username'] != null && trim($parameter['username']) != '') {
            $personel->setUsername(trim($parameter['username']));
         }

        // if ( array_key_exists('prenom', $parameter)  && $parameter['prenom'] && $parameter['prenom'] != null && trim($parameter['prenom']) != '') {
        //     $personel->setPrenom(trim($parameter['prenom']));
        // }

        // if ( array_key_exists('nom', $parameter)   && $parameter['nom'] != null && trim($parameter['nom']) != '') {
        //     $personel->setNom(trim($parameter['nom']));
        // }

        // if ( array_key_exists('adresse', $parameter) &&   $parameter['adresse'] != null && trim($parameter['adresse']) != '') {
        //     $personel->setAdresse(trim($parameter['adresse']));
        // }

        // if ($parameter['date_naissance'] != null && trim($parameter['date_naissance']) != '') {
        //     $personel->setDateNaissance(trim($parameter['date_naissance']));
        // }
        
        // if (array_key_exists('contact', $parameter)  && $parameter['contact'] != null && trim($parameter['contact']) != '') {
        //     $personel->setContact(trim($parameter['contact']));
        // }
        



        // $updatedPerso = $serializer->deserialize(
        //     $request->getContent(), 
        //     Personel::class, 'json', 
        //     [AbstractNormalizer::OBJECT_TO_POPULATE => $Perso]
        // );

        // $content = $request->toArray();

        // $idDep = $content['idDepartement'] ?? -1;
        // $idtyp = $content['IdType'] ?? -1; 

        // $mdp=$updatedPerso->getPassword();

        // $updatedPerso->setPassword($hasher->hashPassword($updatedPerso,$mdp));

        // $updatedPerso->setMdpChanged(true);
        // $Perso->setDepartement($departementRepository->find($idDep));

        // $Perso->setTypePerso($TypeReposity->find($idtyp));

        

        $em->persist($personel);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }

   
    // effacer un utilisateur
    
   // #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
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
   // #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    #[Route('/api/admin/generate/{id}','users_update', methods:['PUT'])]
    public  function personel( EntityManagerInterface $em,UserPasswordHasherInterface $hasher,Personel $personel): Response

    {
       $usernname =  $this->random_str(6);
       $password = $this->random_str(6);
       
       $personel->setUsername($usernname);
       $personel->setPassword($hasher->hashPassword($personel, $password));
       $em->flush();

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
    
    

    #[Route('/api/token','users_token', methods:['GET'])]    
    public function gestTokenUser(UserInterface $user , JWTTokenManagerInterface $Jwttoken): JsonResponse
    {
        return $this->json(data: [
            'user'=> $user
        ], status:Response::HTTP_OK, headers:[], context:['groups' => 'getPersonel']);
        
    }




}
