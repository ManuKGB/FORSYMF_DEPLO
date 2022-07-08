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

class PersonelController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    
    #[Route('/api/admin', name:'Users',methods:['GET'])]
    
    public function index(PersonelRepository $respository):JsonResponse
    {
        $personel = $respository->findAll();
        return $this->json($respository->findAll(), Response::HTTP_OK, [], ['groups' => 'personel:read']);
    }

    // recuperer un personel avec son id 


    
    #[Route('/api/admin/user/{id}', name:'Users_id',methods:['GET'])]
    public function getpersonel(PersonelRepository $respository , $id):JsonResponse
    {
       
        return $this->json($respository->find($id), Response::HTTP_OK, [], ['groups' => 'personel:read']);
    }

    //creation d un utilisateur
    #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    #[Route('/api/admin', name:'users_symfony', methods:['POST'])]
    public function creation(Request $request , EntityManagerInterface $em, UserPasswordHasherInterface $hasher):Response

    {
        $personel= new Personel();
        $parameter =Json_decode($request->getContent(), true);
        
        $personel->setNom($parameter['nom']);
        $personel->setRoles($parameter['roles']);
        $personel->setPassword($hasher->hashPassword($personel, $parameter['password']));
        $personel->setPrenom($parameter['prenom']);
        // 

        $dt=new DateTime();
        $date=$dt->createFromFormat("y-m-d", date("y-m-d", (int) $parameter['date_naissance'] ) );
        $personel->setDateNaissance(($date));
        $personel->setAdresse($parameter['adresse']);
        $personel->setEmail($parameter['email']); 
        $personel->setContact($parameter['contact']); 

        $em->persist($personel);
        $em->flush();

        return $this->Json($personel);
    }

// modification d un utilisateur
    #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    #[Route('/api/admin/{id}','users_update', methods:['PUT'])]
    public  function update_users(Request $request, $id,  EntityManagerInterface $em , PersonelRepository $respository): Response

    {
        $data = $respository->find($id);

        $parameter=Json_decode($request->getContent(), true);
        
        $data->setNom($parameter['nom']);
       // $data->setRoles(['ROLE_USER']);
        $data->setPassword( $parameter['password']);
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
    }
    // effacer un utilisateur
    
    #[IsGranted('ROLE_ADMIN', message : "vous n \etes pas autorise a acceder a cette route")]
    #[Route('/api/admin/{id}','deleted_users', methods:['DELETE'])]
    public function delete_user($id , EntityManagerInterface $em , PersonelRepository $respository  ):Response

    {

        $data=$respository->find($id);

        $em->remove($data);
        $em->flush();
         return $this->Json(' cet utilisateur a été éffacé!');

    }

}
