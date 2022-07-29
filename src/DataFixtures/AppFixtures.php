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



        //creons 10 taches
       for($i=0; $i< 5; $i++)
       {
           $tache = new Taches;
           $tache -> setResume('Faire le front : '.$i);
           $tache -> setPriorite('onglet accueil');

           $dts = new DateTime();
           $datee = $dts -> createFromFormat("y-m-d", date("y-m-d"));
           $tache -> setDateDebutProjet($datee);
           
           $dt = new DateTime();
           $date = $dt -> createFromFormat("y-m-d", date("y-m-d"));
           $tache -> setDateFinEstimeProj($date);

           $tache -> setMotifRetard('');

           $dte = new DateTime();
           $dates = $dte -> createFromFormat("y-m-d", date("y-m-d"));
           $tache -> setDateDerniereMiseAJour($dates);

           $tache -> setActif(1);
           
           $manager -> persist($tache);
       } 

        $manager->flush();




         //creons 10 notifs
       for($i=0; $i< 5; $i++)
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
        for($i = 0; $i < 5; $i++)
        {
            $projet = new Projet;

            $dt = new DateTime();
            $date = $dt -> createFromFormat("y-m-d", date("y-m-d")); 
            $projet -> setDateDebutProj($date);

            $projet -> setDateFinEstimeProj($date);

            $projet -> setTitre ('Je suis le meilleur');

            $projet -> setDateFinProj($date);

            $projet -> setMontantInitialProj('150000');

            $projet -> setMontantProj('200000');

            $projet -> setDateApprove($date);

            $projet -> setActif(1);

        $manager -> persist($projet);
            
        }
        $manager->flush();
























    }

    
}
