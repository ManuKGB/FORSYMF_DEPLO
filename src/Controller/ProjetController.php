<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ProjetController extends AbstractController
{
    #[Route('/api/projets', name: 'allProjet', methods:['GET'])]
    public function getAllProjet(ProjetRepository $projetRepository,
    SerializerInterface $serializer): JsonResponse
    {
        $projet = $projetRepository -> findAll();
        $jsonAllProjet = $serializer -> serialize($projet, 'json', ["groups" => "getprojet"]);
        return new JsonResponse($jsonAllProjet,
        Response::HTTP_OK,[], true); 
        
    }


  


    #[Route('/api/projets/{id}', name: 'detailProjet', methods:['GET'])]
    public function getDetailProjet(Projet $projet, 
    SerializerInterface $serializer) : JsonResponse
    {
        $jsonprojet = $serializer -> serialize($projet, 'json', ["groups" => "getprojet"]);
        return new JsonResponse($jsonprojet, Response::HTTP_OK,
        ['accept' => 'json'], true);
    }
    



    #[ROUTE('/api/projets/{id}', name: 'deleteProjet', methods : ['DELETE'])]
    public function deleteProjet(Projet $projet, EntityManagerInterface $em) : JsonResponse
    {
        $em -> remove($projet);
        $em -> flush();

        return new JsonResponse(null, Response :: HTTP_NO_CONTENT);
    }



    #[Route('/api/projets', name: "createProjet" , methods:['POST'])]
    public function createProjet(Request $request, SerializerInterface
    $serializer, EntityManagerInterface $em, UrlGeneratorInterface
    $urlGenerator): JsonResponse
    {
        $projet = $serializer -> deserialize($request -> getContent(), Projet::class, 'json');
        $em -> persist($projet);
        $em -> flush();


        $jsonprojet = $serializer -> serialize($projet, 'json', ["Groups" =>"getprojet"]);

        $location = $urlGenerator -> generate('detailProjet', ['id' => $projet ->
        getId()] , UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonprojet , Response:: HTTP_CREATED,
        ["Location" => $location] , true);

    }





    #[Route('/api/projets/{id}', name: "updateProjet", methods: ['PUT'])]
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

















}