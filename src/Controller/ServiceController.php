<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ServiceController extends AbstractController
{
    #[Route('/api/service', name: 'app_service',methods:['GET'])]
    public function getAllPres(ServiceRepository $Service,SerializerInterface $serializer):JsonResponse
    {
        $ser=$Service->findBy(
            array('Deleted'=> 0),
        );
        $result = $serializer->serialize($ser, 'json',['groups'=>'getServ']);
        return new JsonResponse($result, Response::HTTP_OK,[],true);
        
    }
    #[Route('/api/service/{id}',methods:['GET'])]
    public function getOnePres(Service $ser, SerializerInterface $serializer):JsonResponse
    {
        $result = $serializer->serialize($ser, 'json',['groups'=>'getServ']);
        if ($ser && !$ser->isDeleted()){
            return new JsonResponse($result, Response::HTTP_OK,[],true);
        }else{
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
      
    }

    #[Route('/api/service/save',methods:['POST'])]
    public function saveAuteur(Request $requete ,SerializerInterface $serializer,EntityManagerInterface $em,
    ValidatorInterface $validator):JsonResponse
    {
        $ser=$serializer->deserialize($requete->getContent(),Service::class,'json');
        $errors = $validator->validate($ser);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $ser->setDeleted(false);
        $em->persist($ser);
        $em->flush();
        $jsonBook = $serializer->serialize($ser, 'json');
        return new JsonResponse($jsonBook, Response::HTTP_CREATED,[],true);

    }


    #[Route('/api/service/update/{id}',methods:['PUT'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour mettre à jour')]
    public function updateBook(Request $request, SerializerInterface $serializer, Service $current, EntityManagerInterface $em, 
    ): JsonResponse 
    {
        $upd = $serializer->deserialize($request->getContent(), 
                Service::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $current]);
        $json=$serializer->serialize($upd,'json');
        $em->persist($upd);
        $em->flush();
        return new JsonResponse($json, JsonResponse::HTTP_OK,[],true);
   }


   #[Route('/api/service/delete/{id}', methods: ['DELETE'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un livre')]
    public function deleteSer(EntityManagerInterface $em  ,Service $current
    ,SerializerInterface $serializer): JsonResponse 
    {
        $current->setDeleted(true);
        $em->persist($current);
        $em->flush();
        $result=$serializer->serialize($current,'json');
        return new JsonResponse($result, Response::HTTP_OK,[],true);
    }
}
