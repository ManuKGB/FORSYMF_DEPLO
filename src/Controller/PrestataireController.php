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
    // VALIDER
    #[Route('/api/prestataire', name: 'all_prest', methods: ['GET'])]
    public function getAllPres(PrestataireRepository $Prestataire, SerializerInterface $serializer): JsonResponse
    {
        $pre = $Prestataire->findBy(
            array('deleted' => 0),
        );
        $result = $serializer->serialize($pre, 'json', ['groups' => 'get']);
        //return $this->json($result);
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    // VALIDER
    #[Route('/api/prestataire/deleted', name: 'all_pres_deleted', methods: ['GET'])]
    public function getDeletedPres(PrestataireRepository $Prestataire, SerializerInterface $serializer): JsonResponse
    {
        $pre = $Prestataire->findBy(
            array('deleted' => 1),
        );
        $result = $serializer->serialize($pre, 'json', ['groups' => 'get']);
        //return $this->json($result);
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    // VALIDER
    #[Route('/api/prestataire/{id}', name: 'one_prest', methods: ['GET'])]
    public function getOnePres(Prestataire $prestataire, SerializerInterface $serializer): JsonResponse
    {
        $result = $serializer->serialize($prestataire, 'json',['groups' => 'get']);
        if ($prestataire && !$prestataire->isDeleted()) {
            return new JsonResponse($result, Response::HTTP_OK, [], true);
        } elseif ($prestataire && $prestataire->isDeleted()) {
            $x = array(
                "status" => JsonResponse::HTTP_NOT_FOUND,
                "message" => "Object not found!"
            );
            $err = $serializer->serialize($x, 'json');
            return new JsonResponse($err, JsonResponse::HTTP_NOT_FOUND, [], true);
        }
    }

    // VALIDER
    #[Route('/api/prestataire/save', methods: ['POST'])]
    public function savePres(
        Request $requete,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        PrestataireRepository $Prestataire
    ): JsonResponse {
        $pre = $serializer->deserialize($requete->getContent(), Prestataire::class, 'json');

        $errors = $validator->validate($pre);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }
        $X = $Prestataire->findBy(
            array(
                'nom' => $pre->getNom(),
                'prenom' => $pre->getPrenom()
            )
        );
        if (count($X) == 0) {
            $pre->setDeleted(false);
            $pre->setActif(true);
            $em->persist($pre);
            $em->flush();
            $jsonBook = $serializer->serialize($pre, 'json',["groups","getServ"]);
            return new JsonResponse($jsonBook, Response::HTTP_CREATED, [], true);
        } else {
            $x = array(
                "status" => JsonResponse::HTTP_ALREADY_REPORTED,
                "message" => "Prestataire deja enregistrer!"
            );
            $err = $serializer->serialize($x, 'json');
            return new JsonResponse($err, JsonResponse::HTTP_ALREADY_REPORTED, [], true);
        }
    }


    // VALIDER
    #[Route('/api/prestataire/update/{id}', methods: ['PUT'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour mettre à jour')]
    public function updatePres(
        Request $request,
        SerializerInterface $serializer,
        Prestataire $current,
        EntityManagerInterface $em,
    ): JsonResponse {
        if ($current && !$current->isDeleted()) {
            $updpres = $serializer->deserialize(
                $request->getContent(),
                Prestataire::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $current]
            );
            $json = $serializer->serialize($updpres, 'json',["groups"=>"get"]);
            $em->persist($updpres);
            $em->flush();
            return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
        } elseif ($current && $current->isDeleted()) {
            $x = array(
                "status" => JsonResponse::HTTP_NOT_FOUND,
                "message" => "Object not found!"
            );
            $err = $serializer->serialize($x, 'json');
            return new JsonResponse($err, JsonResponse::HTTP_NOT_FOUND, [], true);
        }
    }


    // VALIDER
    #[Route('/api/prestataire/deleted/reload/{id}', methods: ['PUT'])]
    public  function reloadDeleted(
        SerializerInterface $serializer,
        Prestataire $current,
        EntityManagerInterface $em
    ): JsonResponse {
        $w = array(
            "statut" => JsonResponse::HTTP_ALREADY_REPORTED,
            "Message" => "Cet objet n'est pas supprimé!"
        );
        $err = $serializer->serialize($w, 'json');
        if ($current && $current->isDeleted()) {
            $current->setDeleted(0);
            $result = $serializer->serialize($current, 'json',["groups"=>"get"]);
            $em->persist($current);
            $em->flush();
            return new JsonResponse($result, JsonResponse::HTTP_OK, [], true);
        } elseif ($current && !$current->isDeleted()) {
            return new JsonResponse($err, JsonResponse::HTTP_ALREADY_REPORTED, [], true);
        }
    }

    // VALIDER
    #[Route('/api/prestataire/delete/{id}', methods: ['DELETE'])]
    // #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un livre')]
    public function deletePres(Prestataire $current, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        if ($current && !$current->isDeleted()) {
            $current->setDeleted(true);
            $em->persist($current);
            $em->flush();
            $result = $serializer->serialize($current, 'json',["groups"=>"get"]);
            return new JsonResponse($result, Response::HTTP_OK, [], true);
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
