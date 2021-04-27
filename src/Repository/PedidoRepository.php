<?php

namespace App\Repository;

use App\Entity\Pedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Pedido|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pedido|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pedido[]    findAll()
 * @method Pedido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Pedido::class);
        $this->manager = $manager;
    }

    public function savePedido($mesa, $precio_total, $fecha, $hora)
    {
        $newPedido = new Pedido();

        $newPedido
            ->setMesa($mesa)
            ->setPrecioTotal($precio_total)
            ->setFecha($fecha)
            ->setHora($hora);

        $this->manager->persist($newPedido);
        $this->manager->flush();
    }

    public function updatePedido(pedido $pedido): pedido
    {
        $this->manager->persist($pedido);
        $this->manager->flush();

        return $pedido;
    }

    public function removePedido(pedido $pedido)
    {
        $this->manager->remove($pedido);
        $this->manager->flush();
    }

    // /**
    //  * @return Pedido[] Returns an array of Pedido objects
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
    public function findOneBySomeField($value): ?Pedido
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
