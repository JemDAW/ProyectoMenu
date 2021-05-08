<?php

namespace App\Repository;

use App\Entity\Empleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Empleado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Empleado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Empleado[]    findAll()
 * @method Empleado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Empleado::class);
        $this->manager = $manager;
    }

    public function saveEmpleado($nombre, $email, $password, $tipo_usuario)
    {
        $newEmpleado = new Empleado();

        $newEmpleado
            ->setNombre($nombre)
            ->setEmail($email)
            ->setPassword($password)
            ->setTipoUsuario($tipo_usuario);

        $this->manager->persist($newEmpleado);
        $this->manager->flush();
    }

    public function updateEmpleado(empleado $empleado): empleado
    {
        $this->manager->persist($empleado);
        $this->manager->flush();

        return $empleado;
    }

    public function removeEmpleado(empleado $empleado)
    {
        $this->manager->remove($empleado);
        $this->manager->flush();
    }

    public function findByMail($text): array
    {
        $qb = $this->createQueryBuilder('c')
        ->andWhere('c.email LIKE :text')
        ->setParameter('text', $text)
        ->getQuery();
        return $qb->execute();
    }
    // /**
    //  * @return Empleado[] Returns an array of Empleado objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Empleado
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
