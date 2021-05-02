<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Item::class);
        $this->manager = $manager;
    }

    public function saveitem($nombre, $precio, $descripcion, $tag)
    {
        $newitem = new item();

        $newitem
            ->setNombre($nombre)
            ->setPrecio($precio)
            ->setDescripcion($descripcion)
            ->setTag($tag);

        $this->manager->persist($newitem);
        $this->manager->flush();
    }

    public function updateitem(item $item): item
    {
        $this->manager->persist($item);
        $this->manager->flush();

        return $item;
    }


    public function removeitem(item $item)
    {
        $this->manager->remove($item);
        $this->manager->flush();
    }

    public function findByTag($text): array
    {
        $qb = $this->createQueryBuilder('c')
        ->andWhere('c.tag LIKE :text')
        ->setParameter('text', '%' . $text . '%')
        ->getQuery();
        return $qb->execute();
    }

    // /**
    //  * @return Item[] Returns an array of Item objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Item
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
