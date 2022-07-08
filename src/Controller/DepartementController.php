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

class DepartementController extends AbstractController
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
  }
    #[Route('api/admin/departements', name: 'app_departement', methods: ['GET'])]
    public function getdepartementList(DepartementRepository $departementRepository, SerializerInterface $serializer): JsonResponse
    {
        $departementList = $departementRepository->findAll();
        $jsondepartementList = $serializer->serialize($departementList, 'json');
        return new JsonResponse($jsondepartementList, Response::HTTP_OK, [], true);
    }

    #[Route('api/admin/departements', name:"createdepartement", methods: ['POST'])]
    public function createdepartement(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,ValidatorInterface $validator): JsonResponse 
    {
        $departement = $serializer->deserialize($request->getContent(), Departement::class, 'json');
        $content = $request->toArray();
          // On vérifie les erreurs
          $errors = $validator->validate($departement);

          if ($errors->count() > 0) {
              return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
          }
      
        $em->persist($departement);
        $em->flush();

        $jsonBook = $serializer->serialize($departement, 'json', ['groups' => 'getDepartement']);
        return new JsonResponse($content, Response::HTTP_CREATED);
   }

    #[Route('api/admin/departements/{id}', name: 'detaildepartement', methods: ['GET'])]
    public function getDetaildepartement(Departement $departement, SerializerInterface $serializer): JsonResponse 
    {
        $jsonBook = $serializer->serialize($departement, 'json');
        return new JsonResponse($jsonBook, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('api/admin/departements/{id}', name: 'deleteBook', methods: ['DELETE'])]

    public function deletedepartement(Departement $departement, EntityManagerInterface $em): JsonResponse 

    {

        $em->remove($departement);

        $em->flush();


        return new JsonResponse(null, Response::HTTP_NO_CONTENT);

    }

}
