<?php

namespace App\Repository;

use App\Entity\Editorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Editorial>
 *
 * @method Editorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Editorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Editorial[]    findAll()
 * @method Editorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditorialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Editorial::class);
    }

    public function findAllPublisher5Books(): array
    {
        return  $this->createQueryBuilder("e")
            ->select("e")
            ->where("SIZE(e.libros) >= 5")
            ->getQuery()
            ->getResult();
    }

    public function listarEditorialesPorNumeroDeLibros(): array
    {
        return $this->createQueryBuilder("e")
            ->select("e")
            ->orderBy("SIZE(e.libros)", "DESC")
            ->getQuery()
            ->getResult();
    }
}