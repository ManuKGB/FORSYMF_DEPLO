<?php

namespace App\Controller;
use App\Entity\TypePerso;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypePersoRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class TypePersoController extends AbstractController
{
    #[Route('api/admin/types', name: 'app_typeperso', methods: ['GET'])]
    public function getdetypeList(TypePersoRepository $typeRepository, SerializerInterface $serializer): JsonResponse
    {
        $typeList = $typeRepository->findBy(
            array('deleted'=>0),
        );
        $jsontypeList = $serializer->serialize($typeList, 'json',['groups'=>'get2']);
        return new JsonResponse($jsontypeList, Response::HTTP_OK, [], true);
    }



    #[Route('api/admin/types/{id}', name: 'detailtype', methods: ['GET'])]
    public function getDetailtype(TypePerso $type, SerializerInterface $serializer)
    { if(!$type->isDeleted()){
        $jsonBook = $serializer->serialize($type, 'json',['groups'=>'get2']);
        return new JsonResponse($jsonBook, Response::HTTP_OK, ['accept' => 'json'], true);
    }
    elseif($type && $type->isDeleted()){
        $x=array(
            "status"=> JsonResponse::HTTP_NOT_FOUND,
            "message"=> "object not found!"
        );
        $err=$serializer->serialize($x,'json' );
        return new JsonResponse($err,JsonResponse::HTTP_NOT_FOUND,[],true);
    }
    }




    #[Route('api/admin/types/{id}', name: 'deletetype', methods: ['DELETE'])]

    public function deletetype(TypePerso $type, EntityManagerInterface $em,SerializerInterface $serializer)

    {

        if ($type && !$type->isDeleted()){
            $type->setDeleted(true);
            $em->flush();
            $reuslt=$serializer->serialize($type, 'json', ['groups' => 'getPersonel']);
            return $this->Json(' ce type a été supprimé!');
        } elseif($type && $type->isDeleted()){
            $x=array(
                "status"=> JsonResponse::HTTP_NOT_FOUND,
                "message"=> "object not found!"
            );
            $err=$serializer->serialize($x,'json' );
            return new JsonResponse($err,JsonResponse::HTTP_NOT_FOUND,[],true);
        }
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
        $type->setDeleted(false);
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


  #[Route('api/testt', name: 'app_departementtt', methods: ['GET'])]
  public function getdepartementListeee(TypePersoRepository $departementRepository, SerializerInterface $serializer): JsonResponse
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

