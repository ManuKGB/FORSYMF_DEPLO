<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypePersoRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\TypePerso;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\DependencyInjection\Compiler\ValidateEnvPlaceholdersPass;

class TypePersoController extends AbstractController
{
    #[Route('api/admin/types', name: 'app_typeperso', methods: ['GET'])]
    public function getdetypeList(TypePersoRepository $typeRepository, SerializerInterface $serializer): JsonResponse
    {
        $typeList = $typeRepository->findAll();
        $jsontypeList = $serializer->serialize($typeList, 'json');
        return new JsonResponse($jsontypeList, Response::HTTP_OK, [], true);
    }


    #[Route('api/admin/types/{id}', name: 'detailtype', methods: ['GET'])]
    public function getDetailtype(TypePerso $type, SerializerInterface $serializer): JsonResponse 
    {
        $jsontype  = $serializer->serialize($type, 'json');
        return new JsonResponse($jsontype, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('api/admin/types/{id}', name: 'deletetype', methods: ['DELETE'])]

    public function deletetype(TypePerso $type, EntityManagerInterface $em): JsonResponse 

    {

        $em->remove($type);

        $em->flush();


        return new JsonResponse(null, Response::HTTP_NO_CONTENT);

    }

    #[Route('api/admin/types', name:"createtype", methods: ['POST'])]
    public function createdepartement(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,ValidatorInterface $validator): JsonResponse 
    {
        $type = $serializer->deserialize($request->getContent(), TypePerso::class, 'json');
        $content = $request->toArray();
        $errors = $validator->validate($type);

          if ($errors->count() > 0) {
              return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
          }
        $em->persist($type);
        $em->flush();

        $jsonType = $serializer->serialize($type, 'json', ['groups' => 'getTypePerso']);
        return new JsonResponse($content, Response::HTTP_CREATED);
   }

   #[Route('api/admin/types/{id}', name:"updatedepartement", methods:['PUT'])]

   public function updatedepartement(Request $request, SerializerInterface $serializer, TypePerso $currentType, EntityManagerInterface $em,ValidatorInterface $validator): JsonResponse 
   {
       $updatedtype = $serializer->deserialize($request->getContent(), 
               TypePerso::class, 
               'json', 
               [AbstractNormalizer::OBJECT_TO_POPULATE => $currentType]);
       $content = $request->toArray();
       $errors = $validator->validate($updatedtype);

          if ($errors->count() > 0) {
              return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
          }
       $em->persist($updatedtype);
       $em->flush();
       return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
  }

}
