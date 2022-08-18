<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\DepartementRepository;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Departement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\PersonelRepository;
use App\Entity\Personel;
use Doctrine\ORM\Mapping\Id;

class DepartementController extends AbstractController



//update
{
    #[Route('api/admin/departements/{id}', name: 'departementu', methods: ['PUT'])]
   public function updatedepartement(Request $request, SerializerInterface $serializer, Departement $currentDepartement, EntityManagerInterface $em,ValidatorInterface $validator): JsonResponse 
   {
       $updatedDepartement = $serializer->deserialize($request->getContent(), 
               Departement::class, 
               'json', 
               [AbstractNormalizer::OBJECT_TO_POPULATE => $currentDepartement]);
       $content = $request->toArray();
       $errors = $validator->validate($updatedDepartement);

       if ($errors->count() > 0) {
           return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
       }
       $em->persist($updatedDepartement);
       $em->flush();
       return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);




  //get all
  }
    #[Route('api/admin/departements', name: 'app_departement', methods: ['GET'])]
    public function getdepartementList(DepartementRepository $departementRepository, SerializerInterface $serializer): JsonResponse
    {
        $departementList = $departementRepository->findBy(
            array('deleted'=>0),
        );
        $jsondepartementList = $serializer->serialize($departementList, 'json',['groups'=>'get6']);
        return new JsonResponse($jsondepartementList, Response::HTTP_OK, [], true);
    }




    //create 
    #[Route('api/admin/departements', name:"createdepartement", methods: ['POST'])]
    public function createdepartement(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,ValidatorInterface $validator,PersonelRepository $perss): JsonResponse 
    {
        $departement = $serializer->deserialize($request->getContent(), Departement::class, 'json');
        $content = $request->toArray();
          // On vérifie les erreurs
          $errors = $validator->validate($departement);

          if ($errors->count() > 0) {
              return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
          }
        
        $departement->setDeleted(false);
        $idPers=$content['idChef'] ?? -1;
        $departement->setChef($perss->find($idPers));
        
        $em->persist($departement);
        $em->flush();
        $jsonBook = $serializer->serialize($departement, 'json',['groups'=>'get2']);
        return new JsonResponse($content, Response::HTTP_CREATED);
   }





   //find
    #[Route('api/admin/departements/{id}', name: 'detaildepartement', methods: ['GET'])]

    public function getDetaildepartement(Departement $departement, SerializerInterface $serializer) 
    {
        if(!$departement->isDeleted()){
            //foreach($departement)
            $jsonBook = $serializer->serialize($departement, 'json',['groups'=>'get6']);
            return new JsonResponse($jsonBook, Response::HTTP_OK, ['accept' => 'json'], true);
        }
        elseif($departement && $departement->isDeleted()){
            $x=array(
                "status"=> JsonResponse::HTTP_NOT_FOUND,
                "message"=> "object not found!"
            );
            $err=$serializer->serialize($x,'json' );
            return new JsonResponse($err,JsonResponse::HTTP_NOT_FOUND,[],true);
        } 
    }


 

    

/////dele
    #[Route('api/admin/departements/{id}', name: 'deleteBook', methods: ['DELETE'])]

    public function deletedepartement(Departement $departement, EntityManagerInterface $em,SerializerInterface $serializer)

    {

        if ($departement && !$departement->isDeleted()){
            $departement->setDeleted(true);
            $em->flush();
            $reuslt=$serializer->serialize($departement, 'json', ['groups' => 'getPersonel']);
            return $this->Json(' ce departement a été supprimé!');
        } elseif($departement && $departement->isDeleted()){
            $x=array(
                "status"=> JsonResponse::HTTP_NOT_FOUND,
                "message"=> "object not found!"
            );
            $err=$serializer->serialize($x,'json' );
            return new JsonResponse($err,JsonResponse::HTTP_NOT_FOUND,[],true);
        }
       
    }



    //perso du departements
    #[Route('api/admin/departements/{id}/chef/{id2}', name: 'detaildepartementt', methods: ['PUT'])]
    public function getDetaildepartementt(Departement $departement, SerializerInterface $serializer,EntityManagerInterface $em, 
    PersonelRepository $personelRepository, DepartementRepository $departementReposity,int $id,int $id2) 
    {
        if(!$departement->isDeleted()){
            $jsonBook = $serializer->serialize($departement, 'json',['groups'=>'get5']);
            $data = $departementReposity->find($id);
            $chef = $personelRepository->find($id2);
            $x=array();
            $chef->getId();
            $data->setChef($chef);
            $em->persist($data);
            $em->flush();

            // foreach($data->getPersonel() as $personnel) {
            //     if ($personnel->getId() != $chef->getId()) {
            //         $personnel->setPersonel($chef);
            //         $em->persist($personnel);
            //         $em->flush();

            //     }
            // }
            // $personnel->setIschef(false);
            // $em->persist($personnel);
            // $em->flush();
            
            $jsonBook = $serializer->serialize($data, 'json',['groups'=>'get2']);
            // return new JsonResponse($data->getPersonel()[0]->getpersonelname());
             return new JsonResponse("", Response::HTTP_OK,[],true);
        }
        elseif($departement && $departement->isDeleted()){
            $x=array(
                "status"=> JsonResponse::HTTP_NOT_FOUND,
                "message"=> "object not found!"
            );
            $err=$serializer->serialize($x,'json' );
            return new JsonResponse($err,JsonResponse::HTTP_NOT_FOUND,[],true);
        } 
    }


    




    #[Route('api/test', name: 'app_departementt', methods: ['GET'])]
    public function getdepartementListe(DepartementRepository $departementRepository, SerializerInterface $serializer): JsonResponse
    {
        $departementList = $departementRepository->findBy(
            array('deleted'=>0),
            
        );
        $e=array();
        foreach($departementList as $d){
            $e=$d->getId();
        }
        $jsondepartementList = $serializer->serialize($departementList, 'json',['groups'=>'get2']);
        $x=array(
            "status"=> "200",
            "message"=>$e
        );
        $err=$serializer->serialize($x,'json' );
        return new JsonResponse($err, Response::HTTP_OK, [], true);
    }


    

}
