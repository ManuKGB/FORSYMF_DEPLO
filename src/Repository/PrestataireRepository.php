<?php

namespace App\Repository;

use App\Entity\Prestataire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prestataire>
 *
 * @method Prestataire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestataire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestataire[]    findAll()
 * @method Prestataire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestataire::class);
    }

    public function add(Prestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function remove(Prestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

// //    /**
// <<<<<<<< HEAD:src/Repository/ProjetRepository.php
// //     * @return Projet[] Returns an array of Projet objects
// ========
// //     * @return Prestataire[] Returns an array of Prestataire objects
// >>>>>>>> origin/Emmanuel:src/Repository/PrestataireRepository.php
// //     */
// //    public function findByExampleField($value): array
// //    {
// //        return $this->createQueryBuilder('p')
// //            ->andWhere('p.exampleField = :val')
// //            ->setParameter('val', $value)
// //            ->orderBy('p.id', 'ASC')
// //            ->setMaxResults(10)
// //            ->getQuery()
// //            ->getResult()
// //        ;
// //    }

// <<<<<<<< HEAD:src/Repository/ProjetRepository.php
// //    public function findOneBySomeField($value): ?Projet
// ========
// //    public function findOneBySomeField($value): ?Prestataire
// >>>>>>>> origin/Emmanuel:src/Repository/PrestataireRepository.php
// //    {
// //        return $this->createQueryBuilder('p')
// //            ->andWhere('p.exampleField = :val')
// //            ->setParameter('val', $value)
// //            ->getQuery()
// //            ->getOneOrNullResult()
// //        ;
// //    }
}
