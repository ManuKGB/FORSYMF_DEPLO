<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends AbstractController
{
    #[Route('/api/login_check','api_login', methods:['POST'])]
    public function api_login(): JsonResponse
    {
        $personel= $this->getUser();
        return new JsonResponse([

            'username'=>$personel->getUserIdentifier(),
            'roles'=>$personel->getRoles()
        ]);

    }
}