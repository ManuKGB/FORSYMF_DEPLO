<?php

namespace App\DataFixtures;

//use App\Entity\Notifications;

use App\Entity\Notification;
use App\Entity\Projet;
use App\Entity\Taches;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        // //creation de notifications
        // $listNotif = [];
        // for ($i = 0; $i < 10; $i++)
        // {
        //     $notif = new Notification();
        //     $notif -> setCodeNotif('pople');
        //     $notif -> setContenuNotif('Votre tache doit être terminé avant demain');
            
        //     $dts = new DateTime();
        //     $date = $dts -> createFromFormat("y-m-d", date("y-m-d"));
        //     $notif ->  setDateNotif($date);

        //     $manager -> persist($notif);
        //     //sauvegarde de l'auteur cree dans le tableau
        //     $listNotif[] = $notif;
        // }






       //creons 10 taches
    //    for($i=0; $i< 10; $i++)
    //    {
    //        $tache = new Taches;
    //        $tache -> setResume('Faire le front : '.$i);
    //        $tache -> setPriorite('onglet accueil');

    //        $dts = new DateTime();
    //        $datee = $dts -> createFromFormat("y-m-d", date("y-m-d"));
    //        $tache -> setDateDebutProjet($datee);
           
    //        $dt = new DateTime();
    //        $date = $dt -> createFromFormat("y-m-d", date("y-m-d"));
    //        $tache -> setDateFinEstimeProj($date);

    //        $tache -> setMotifRetard('');

    //        $dte = new DateTime();
    //        $dates = $dte -> createFromFormat("y-m-d", date("y-m-d"));
    //        $tache -> setDateDerniereMiseAJour($dates);
           
    //        $manager -> persist($tache);
    //    } 

    //     $manager->flush();




         //creons 10 notifs
       for($i=0; $i< 10; $i++)
       {
           $notification = new Notification;

           $notification -> setCodeNotif('notif12');

           $notification ->setContenuNotif('Il vous reste 3 jours !!!!');

           $dts = new DateTime();
           $datee = $dts -> createFromFormat("y-m-d", date("y-m-d"));
           $notification -> setDateNotif($datee);
           
           
           $manager -> persist($notification);
       } 

        $manager->flush(); 



        //creation de projets
        // for($i = 0; $i < 10; $i++)
        // {
        //     $projet = new Projet;

        //     $dt = new DateTime();
        //     $date = $dt -> createFromFormat("y-m-d", date("y-m-d")); 
        //     $projet -> setDateDebutProj($date);

        //     $projet -> setDateFinEstimeProj($date);

        //     $projet -> setDateFinProj($date);

        //     $projet -> setMontantInitialProj('150000');

        //     $projet -> setMontantProj('200000');

        //     $projet -> setDateApprove($date);

        // $manager -> persist($projet);
            
        // }
        // $manager->flush();
























    }

    
}
