<?php

namespace App\Controller;

// namespace App\TacheController;

use App\Entity\Projet;
use App\Entity\Taches;
use App\Entity\Personel;
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


class personelTacheController extends AbstractController
{
    
    // public function personelTacheAction(Request $request)
    // {

    //     $em = $this -> getDoctrine() -> getManager();
    //     $tache1 = $em -> getRepository( Taches::class)->find(id:'1');
    //     $tache2 = $em -> getRepository((Taches::class))->find(id:'2');
    //     $personel -> new Personels();
    //     $personel = set
    //     return $this -> render(view : 'home/home.html.twig');
    // }
}