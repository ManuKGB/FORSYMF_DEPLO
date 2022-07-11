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
// 
// LES END POINTS  MARCHENT BIEN 
// 
class ServiceController extends AbstractController
{
    //VALIDER
    #[Route('/api/service', name: 'app_service', methods: ['GET'])]
    public function getAllSer(ServiceRepository $Service, SerializerInterface $serializer): JsonResponse
    {
        $ser = $Service->findBy(
            array('deleted' => 0),
        );
        $result = $serializer->serialize($ser, 'json', ['groups' => 'getServ']);
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }


    //VALIDER
    #[Route('/api/service/deleted', name: 'all_serv_deleted', methods: ['GET'])]
    public function getDeletedPres(ServiceRepository $Service, SerializerInterface $serializer): JsonResponse
    {
        $pre = $Service->findBy(
            array('deleted' => 1),
        );
        $result = $serializer->serialize($pre, 'json', ['groups' => 'getServ']);
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }


    // VALIDER
    #[Route('/api/service/{id}', methods: ['GET'])]
    public function getOneSer(Service $ser, SerializerInterface $serializer): JsonResponse
    {
        $result = $serializer->serialize($ser, 'json', ['groups' => 'getServ']);
        if ($ser && !$ser->isDeleted()) {
            return new JsonResponse($result, Response::HTTP_OK, [], true);
        } elseif ($ser && $ser->isDeleted()) {
            $x = array(
                "status" => JsonResponse::HTTP_NOT_FOUND,
                "message" => "Object not found!"
            );
            $err = $serializer->serialize($x, 'json');
            return new JsonResponse($err, JsonResponse::HTTP_NOT_FOUND,[],true);
        }
    }


    // VALIDER
    #[Route('/api/service/save', methods: ['POST'])]
    public function saveServ(
        Request $requete,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        $ser = $serializer->deserialize($requete->getContent(), Service::class, 'json');
        $errors = $validator->validate($ser);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $ser->setDeleted(false);
        $em->persist($ser);
        $em->flush();
        $jsonBook = $serializer->serialize($ser, 'json');
        return new JsonResponse($jsonBook, Response::HTTP_CREATED, [], true);
    }

// VALIDER
    #[Route('/api/service/update/{id}', methods: ['PUT'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour mettre à jour')]
    public function updateServ(
        Request $request,
        SerializerInterface $serializer,
        Service $current,
        EntityManagerInterface $em,
    ): JsonResponse {
        if ($current && !$current->isDeleted()) {
            $upd = $serializer->deserialize(
                $request->getContent(),
                Service::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $current]
            );
            $json = $serializer->serialize($upd, 'json');
            $em->persist($upd);
            $em->flush();
            return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
        } elseif ($current && $current->isDeleted()) {
            $x = array(
                "status" => JsonResponse::HTTP_NOT_FOUND,
                "message" => "Object not found!"
            );
            $err = $serializer->serialize($x, 'json');
            return new JsonResponse($err, JsonResponse::HTTP_NOT_FOUND,[],true);
        }
    }

// VALIDER
    #[Route('/api/service/deleted/reload/{id}', methods: ['PUT'])]
    public  function reloadDeleted(
        SerializerInterface $serializer,
        Service $current,
        EntityManagerInterface $em
    ): JsonResponse {
        $w = array(
            "statut" => JsonResponse::HTTP_ALREADY_REPORTED,
            "Message" => "Cet objet n'est pas supprimé!"
        );
        $err = $serializer->serialize($w, 'json');
        if ($current && $current->isDeleted()) {
            $result = $serializer->serialize($current, 'json');
            $current->setDeleted(0);
            $em->persist($current);
            $em->flush();
            return new JsonResponse($result, JsonResponse::HTTP_OK, [], true);
        } elseif ($current && !$current->isDeleted()) {
            return new JsonResponse($err, JsonResponse::HTTP_ALREADY_REPORTED, [], true);
        }
    }


    // VALIDER
    #[Route('/api/service/delete/{id}', methods: ['DELETE'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un livre')]
    public function deleteSer(
        EntityManagerInterface $em,
        Service $current,
        SerializerInterface $serializer
    ): JsonResponse {
        if ($current && !$current->isDeleted()) {
            $current->setDeleted(true);
            $em->persist($current);
            $em->flush();
            $result = $serializer->serialize($current, 'json');
            return new JsonResponse($result, JsonResponse::HTTP_OK, [], true);
        } elseif ($current && $current->isDeleted()) {
            $x = array(
                "status" => JsonResponse::HTTP_NOT_FOUND,
                "message" => "Object not found!"
            );
            $err = $serializer->serialize($x, 'json');
            return new JsonResponse($err, JsonResponse::HTTP_NOT_FOUND,[],true);
        }
    }


}
