<?php

namespace App\Controller;

// namespace App\TacheController;

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


class TacheController extends AbstractController
{



    #[Route('/api/taches', name: 'appTache', methods:['GET'])]
    public function getTacheList(TachesRepository $tacheRepository,
    SerializerInterface $serializer): JsonResponse
    {
        //dd();
        //$tacheList = $tacheRepository -> findAll();
        $tacheList = $tacheRepository -> findBy(array('actif' => 1));
        $jsonTacheList = $serializer -> serialize($tacheList, 'json', ["groups" => "gettaches"]);
        return new JsonResponse($jsonTacheList,
        Response::HTTP_OK,[], true); 
        
    }


  


    #[Route('/api/taches/{id}', name: 'detailOfTache', methods:['GET'])]
    public function getDetailTache(Taches $tache, 
    SerializerInterface $serializer) : JsonResponse
    {
        $jsonTache = $serializer -> serialize($tache, 'json',["groups" => "gettaches"]);
        return new JsonResponse($jsonTache, Response::HTTP_OK,
        ['accept' => 'json'], true);
    }
    



    #[ROUTE('/api/taches/delete/{id}', name: 'DeleteTache', methods : ['DELETE'])]
    public function deleteTache(Taches $taches, EntityManagerInterface $em, SerializerInterface $serializer) : JsonResponse
    {
        if($taches && $taches -> isActif())
        {
            $taches -> setActif(false);
            $em -> persist($taches);
            $em -> flush();
            $mama = $serializer -> serialize($taches, 'json', ["groups" => "gettaches"]);
            return new JsonResponse($mama, Response::HTTP_OK,
            ['accept' => 'json'],true);
        }
        else if($taches && !$taches -> isActif())
        {
            $pov = array(
                "statut" => JsonResponse::HTTP_NOT_FOUND,
                "message" => 'Cette tâche a été supprimée',
            );
            $pova = $serializer->serialize($pov,'json');
            return new JsonResponse($pova,JsonResponse::HTTP_NOT_FOUND,[],true);
        }
    }


   


    #[Route('/api/taches/update/{id}', name: "updateTaches", methods: ['PUT'])]
    public function updateTache(Request $request, SerializerInterface $serializer, Taches $currentTache ,
    EntityManagerInterface $em): JsonResponse
    {
        $updateTache = $serializer ->deserialize($request -> getContent(),
        Taches::class,
        'json',
        [AbstractNormalizer::OBJECT_TO_POPULATE => $currentTache]);
        $em -> persist($updateTache);
        $em -> flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);

    } 



    #[Route('/api/taches/add', name: "createTache" , methods:['POST'])]
    public function createTache(Request $request, SerializerInterface
    $serializer, EntityManagerInterface $em, UrlGeneratorInterface
    $urlGenerator, ValidatorInterface $validator, ProjetRepository $projetRepository): JsonResponse
    {
        $tache = $serializer -> deserialize($request -> getContent(), Taches::class, 'json');
        
        //On vérifie les erreurs
         $error = $validator -> validate ($tache);
         if($error -> count() > 0 )
        {
             return new JsonResponse($serializer -> serialize($error,'json'), JsonResponse::HTTP_BAD_REQUEST,[],true);
            //throw new HttpException(JsonResponse::HTTP_BAD_REQUEST,"la reuête est invalide");
        }
        // $em -> persist($tache);
        // $em -> flush();

        $contenu =$request->toArray();
        $projet_id = $contenu['projet_id']?? -1;
        $tache-> setProjet($projetRepository-> find($projet_id));

        $tache->setActif(true); 
        $em -> persist($tache);
        $em -> flush();


        $jsonTache = $serializer -> serialize($tache, 'json', ['groups' => 
        'getTaches']);

        $location = $urlGenerator -> generate('detailOfTache', ['id' => $tache ->
        getId()] , UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonTache , Response:: HTTP_CREATED,
        ["Location" => $location] , true);

    }
    




    











}