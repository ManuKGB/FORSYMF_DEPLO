<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
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

class NotificationController extends AbstractController
{

    #[Route('/api/notifications', name: 'allNotif', methods:['GET'])]
    public function getAllNotif(NotificationRepository $notificationRepository,
    SerializerInterface $serializer): JsonResponse
    {
        $notification = $notificationRepository -> findAll();
        $jsonAllNotif = $serializer -> serialize($notification, 'json', ["groups" => "getNotif"]);
        return new JsonResponse($jsonAllNotif,
        Response::HTTP_OK,[], true); 
        
    }
    


  


    #[Route('/api/notifications/{id}', name: 'detailNotif', methods:['GET'])]
    public function getDetailNotif(Notification $notification, 
    SerializerInterface $serializer) : JsonResponse
    {
        $jsonNotif = $serializer -> serialize($notification, 'json', ["groups" => "getNotif"]);
        return new JsonResponse($jsonNotif, Response::HTTP_OK,
        ['accept' => 'json'], true);
    }
    



    #[ROUTE('/api/notifications/delete/{id}', name: 'deleteNotif', methods : ['DELETE'])]
    public function deleteNotif(Notification $notification, EntityManagerInterface $em) : JsonResponse
    {
        $em -> remove($notification);
        $em -> flush();

        return new JsonResponse(null, Response :: HTTP_NO_CONTENT);
    }



    #[Route('/api/notifications/add', name: "createNotif" , methods:['POST'])]
    public function createNotif(Request $request, SerializerInterface
    $serializer, EntityManagerInterface $em, UrlGeneratorInterface
    $urlGenerator, ValidatorInterface $validator): JsonResponse
    {
        $notification = $serializer -> deserialize($request -> getContent(), Notification::class, 'json');

        $error = $validator -> validate ($notification);

        if($error -> count() > 0 )
        {
             return new JsonResponse($serializer -> serialize($error,'json'), JsonResponse::HTTP_BAD_REQUEST,[],true);
            //throw new HttpException(JsonResponse::HTTP_BAD_REQUEST,"la reuête est invalide");
        }
        $em -> persist($notification);
        $em -> flush();


        $jsonNotif = $serializer -> serialize($notification, 'json', ["Groups" =>"getNotif"]);

        $location = $urlGenerator -> generate('detailNotif', ['id' => $notification ->
        getId()] , UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonNotif , Response:: HTTP_CREATED,
        ["Location" => $location] , true);

    }





    #[Route('/api/notifications/update/{id}', name: "updateNotif", methods: ['PUT'])]
    public function updateNotif(Request $request, SerializerInterface $serializer, Notification $currentnotification,
    EntityManagerInterface $em): JsonResponse
    {
        $updateNotif = $serializer -> deserialize ($request -> getContent(),
        Notification::class,'json',
        [AbstractNormalizer::OBJECT_TO_POPULATE => $currentnotification]);
        $em -> persist($updateNotif);
        $em -> flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }












}
