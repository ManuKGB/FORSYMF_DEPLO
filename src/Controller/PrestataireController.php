<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Repository\PrestataireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PrestataireController extends AbstractController
{
    #[Route('/api/prestataire', name: 'all_prest',methods:['GET'])]
    public function getAllPres(PrestataireRepository $Prestataire,SerializerInterface $serializer):JsonResponse
    {
        $pre=$Prestataire->findBy(
            array('Deleted'=> 0),
        );
        $result = $serializer->serialize($pre, 'json',['groups'=>'getPrest']);
        //return $this->json($result);
        return new JsonResponse($result, Response::HTTP_OK, [],true);
        
    }


    #[Route('/api/prestataire/{id}',name:'one_prest',methods:['GET'])]
    public function getOnePres(Prestataire $prestataire ,SerializerInterface $serializer): JsonResponse
    {
        $result = $serializer->serialize($prestataire, 'json');
        if ($prestataire && !$prestataire->isDeleted()) {      
            return new JsonResponse($result, Response::HTTP_OK, [], true);
        }else{
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/api/prestataire/save',methods:['POST'])]
    public function saveAuteur(Request $requete ,SerializerInterface $serializer,EntityManagerInterface $em,
    ValidatorInterface $validator):JsonResponse
    {
        $pre=$serializer->deserialize($requete->getContent(),Prestataire::class,'json');
        $errors = $validator->validate($pre);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $pre->setDeleted(false);
        $em->persist($pre);
        $em->flush();
        $jsonBook = $serializer->serialize($pre, 'json');
        return new JsonResponse($jsonBook, Response::HTTP_CREATED,[],true);

    }

    #[Route('/api/prestataire/update/{id}',methods:['PUT'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour mettre à jour')]
    public function updateBook(Request $request, SerializerInterface $serializer, Prestataire $current, EntityManagerInterface $em, 
    ): JsonResponse 
    {
        $updpres = $serializer->deserialize($request->getContent(), 
                Prestataire::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $current]);
        $json=$serializer->serialize($updpres,'json');
        $em->persist($updpres);
        $em->flush();
        return new JsonResponse($json, JsonResponse::HTTP_OK,[],true);
   }

   #[Route('/api/prestataire/delete/{id}', methods: ['DELETE'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un livre')]
    public function deletePres(Prestataire $current, EntityManagerInterface $em,SerializerInterface $serializer): JsonResponse 
    {
        $current->setDeleted(true);
        $em->persist($current);
        $em->flush();
        $result=$serializer->serialize($current,'json');
        return new JsonResponse($result, Response::HTTP_OK,[],true);
    }

}
