<?php

namespace App\Repository;

use App\Entity\Autor;
use App\Entity\Libro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Autor>
 *
 * @method Autor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Autor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Autor[]    findAll()
 * @method Autor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Autor::class);
    }

    public function findAutorByLibro(Libro $libro): array
    {
        return $this->createQueryBuilder("a")
            ->select("a")
            ->where("a.libros = :libro")
            ->setParameter("libro", $libro)
            ->getQuery()
            ->getResult();
    }

    public function findAllYoungestAutor(): array
    {
        return $this->createQueryBuilder("a")
            ->select("a, SIZE(a.libros) AS countLibros")
            ->orderBy("a.fechaNacimiento", "DESC")
            ->getQuery()
            ->getResult();
    }
}