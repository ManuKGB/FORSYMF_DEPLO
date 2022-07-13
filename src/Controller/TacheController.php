<?php

namespace App\Controller;

// namespace App\TacheController;

use App\Entity\Taches;
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

class TacheController extends AbstractController
{



    #[Route('/api/taches', name: 'appTache', methods:['GET'])]
    public function getTacheList(TachesRepository $tacheRepository,
    SerializerInterface $serializer): JsonResponse
    {
        $tacheList = $tacheRepository -> findAll();
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
    



    #[ROUTE('/api/taches/{id}', name: 'DeleteTache', methods : ['DELETE'])]
    public function deleteTache(Taches $taches, EntityManagerInterface $em) : JsonResponse
    {
        $em -> remove($taches);
        $em -> flush();

        return new JsonResponse(null, Response :: HTTP_NO_CONTENT);
    }



    #[Route('/api/taches', name: "createTache" , methods:['POST'])]
    public function createTache(Request $request, SerializerInterface
    $serializer, EntityManagerInterface $em, UrlGeneratorInterface
    $urlGenerator): JsonResponse
    {
        $tache = $serializer -> deserialize($request -> getContent(), Taches::class, 'json');
        $em -> persist($tache);
        $em -> flush();


        $jsonTache = $serializer -> serialize($tache, 'json', ['groups' => 
        'getTaches']);

        $location = $urlGenerator -> generate('detailOfTache', ['id' => $tache ->
        getId()] , UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonTache , Response:: HTTP_CREATED,
        ["Location" => $location] , true);

    }
    




    #[Route('/api/taches/{id}', name: "updateTaches", methods: ['PUT'])]
    
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











}