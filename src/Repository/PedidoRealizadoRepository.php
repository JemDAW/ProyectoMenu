<?php

namespace App\Repository;

use App\Entity\PedidoRealizado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PedidoRealizado|null find($id, $lockMode = null, $lockVersion = null)
 * @method PedidoRealizado|null findOneBy(array $criteria, array $orderBy = null)
 * @method PedidoRealizado[]    findAll()
 * @method PedidoRealizado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoRealizadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PedidoRealizado::class);
    }

    // /**
    //  * @return PedidoRealizado[] Returns an array of PedidoRealizado objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PedidoRealizado
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
