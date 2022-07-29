<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Taches;
use App\Repository\ProjetRepository;
use App\Repository\TachesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class ProjetController extends AbstractController
{
    #[Route('/api/projets', name: 'allProjet', methods:['GET'])]
    public function getAllProjet(ProjetRepository $projetRepository,
    SerializerInterface $serializer): JsonResponse
    {
        $oops = $projetRepository -> findBy(array('actif' => 1)); 
        //dd(); 
        $jsonAllProjet = $serializer -> serialize($oops, 'json', ["groups" => "getprojet"]);
        return new JsonResponse($jsonAllProjet,
        Response::HTTP_OK,[], true); 
        
    }


    #[Route('/api/projets/corbeille', name: 'CorbProjet', methods:['GET'])]
    public function getCorbProjet(ProjetRepository $projetRepository,
    SerializerInterface $serializer): JsonResponse
    {
        $oops = $projetRepository -> findBy(array('actif' => 0)); 
        //dd(); 
        $jsonAllProjet = $serializer -> serialize($oops, 'json', ["groups" => "getprojet"]);
        return new JsonResponse($jsonAllProjet,
        Response::HTTP_OK,[], true); 
        
    }


  


    #[Route('/api/projets/{id}', name: 'detailProjet', methods:['GET'])]
    public function getDetailProjet(Projet $projet, 
    SerializerInterface $serializer) : JsonResponse
    {
        //$pool = $projet -> findBy(array('actif'=>1));
        $jsonprojet = $serializer -> serialize($projet, 'json', ["groups" => "getprojet"]);
        return new JsonResponse($jsonprojet, Response::HTTP_OK,
        ['accept' => 'json'], true);
    }



    #[Route('/api/projets/add', name: "createProjet" , methods:['POST'])]
    public function createProjet(Request $request, SerializerInterface
    $serializer, EntityManagerInterface $em, UrlGeneratorInterface
    $urlGenerator, ValidatorInterface $validator): JsonResponse
    {
        
        $projet = $serializer -> deserialize($request -> getContent(), Projet::class, 'json');

         //On vérifie les erreurs
         $error = $validator -> validate ($projet);
         if($error -> count() > 0 )
        {
             return new JsonResponse($serializer -> serialize($error,'json'), JsonResponse::HTTP_BAD_REQUEST,[],true);
            //throw new HttpException(JsonResponse::HTTP_BAD_REQUEST,"la reuête est invalide");
        }
        $projet->setActif(true); 
        
        $em -> persist($projet);
        $em -> flush();

        $jsonprojet = $serializer -> serialize($projet, 'json', ["Groups" =>"getprojet"]);

        $location = $urlGenerator -> generate('detailProjet', ['id' => $projet ->
        getId()] , UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonprojet , Response:: HTTP_CREATED,
        ["Location" => $location] , true);

    }





    #[Route('/api/projets/update/{id}', name: "updateProjet", methods: ['PUT'])]
    public function updateProjet(Request $request, SerializerInterface $serializer, Projet $currentProjet,
    EntityManagerInterface $em): JsonResponse
    {
        $updateProjet = $serializer -> deserialize ($request -> getContent(),
        Projet::class,'json',
        [AbstractNormalizer::OBJECT_TO_POPULATE => $currentProjet]);
        $em -> persist($updateProjet);
        $em -> flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/api/projets/delete/{id}', name: "delProjet", methods: ['DELETE'])]
    public function delProjet(  Projet $currentProjet,
    EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        if ($currentProjet && $currentProjet -> isActif())
        {
            $currentProjet->setActif(false);
            $em -> persist($currentProjet);
            $em -> flush();
            $popo = $serializer -> serialize($currentProjet, 'json', ["groups" => "getprojet"]);
            return new JsonResponse($popo, Response::HTTP_OK,[], true);
        }
        else if($currentProjet && !$currentProjet -> isActif())
        {
            $yo = array(
                "statut" => JsonResponse::HTTP_NOT_FOUND,
                "message" => " Ce projet a déjà été supprimé "
            );
            $error = $serializer->serialize($yo,'json');
            return new JsonResponse($error,JsonResponse::HTTP_NOT_FOUND,[],true);
        }

    }

    #[ROUTE('/api/projets/del/{id}', name: 'reintegrerTache', methods : ['DELETE'])]
    public function delTache(Taches $taches,Projet $projet ,EntityManagerInterface $em, SerializerInterface $serializer) : JsonResponse
    {
        if($projet.$taches && $projet.$taches -> isActif())
        {
            $projet.$taches -> setActif(false);
            $em -> persist($taches);
            $em -> flush();
            $mama = $serializer -> serialize($projet.$taches, 'json', ["groups" => "gettaches"]);
            return new JsonResponse($mama, Response::HTTP_OK,
            ['accept' => 'json'],true);
        }
        else if($projet.$taches && !$projet.$taches -> isActif())
        { 
            $pov = array(
                "statut" => JsonResponse::HTTP_NOT_FOUND,
                "message" => 'Cette tâche a été supprimée',
            );
            $pova = $serializer->serialize($pov,'json');
            return new JsonResponse($pova,JsonResponse::HTTP_NOT_FOUND,[],true);
        }
        
    }

    
    #[Route('/api/projets/delcorbeille/{id}', name: "reintegrerProjet", methods: ['DELETE'])]
    public function reintegrerProjet(Projet $currentProjet,
    EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        if ($currentProjet && !$currentProjet -> isActif())
        {
            $currentProjet->setActif(true);
            $em -> persist($currentProjet);
            $em -> flush();
            $popo = $serializer -> serialize($currentProjet, 'json', ["groups" => "getprojet"]);
            return new JsonResponse($popo, Response::HTTP_OK,[], true);
        }
        else if($currentProjet && !$currentProjet -> isActif())
        {
            $yo = array(
                "statut" => JsonResponse::HTTP_NOT_FOUND,
                "message" => " Ce projet a déjà été supprimé "
            );
            $error = $serializer->serialize($yo,'json');
            return new JsonResponse($error,JsonResponse::HTTP_NOT_FOUND,[],true);
        }

    }


    















}