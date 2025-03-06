<?php

namespace App\Repository;

use App\Entity\Libro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Libro>
 *
 * @method Libro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Libro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Libro[]    findAll()
 * @method Libro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libro::class);
    }

    //createQueryBuilder --> ponemos el alia del objeto del repositorio (en este caso libros)
    //select --> ponemos lo que queremos que nos devulva (en este caso el libro entero)

    public function findLibrosGeneral(): QueryBuilder
    {
        return $this->createQueryBuilder("l")
            ->select("l, e")
            ->join("l.editorial", "e");
    }

    public function findAllLibros(): array
    {
        return  $this->findLibrosGeneral()
            ->getQuery()
            ->getResult();
    }

    public function findAllLibrosOrderByTitle(): array
    {
        return $this->createQueryBuilder("l")
            ->select("l")
            ->orderBy("l.titulo", "ASC")
            ->getQuery()
            ->getResult();
    }

    public function findAllLibrosOrderByPubDate(): array
    {
        return $this->findLibrosGeneral()
            ->orderBy("l.anioPublicacion", "DESC")
            ->getQuery()
            ->getResult();
    }
    public function findAllTitleWordWritten($palabra): array
    {
        return $this->findLibrosGeneral()
            ->select("l")
            ->where("l.titulo LIKE :palabra")
            ->setParameter("palabra", "%" . $palabra . "%")
            ->getQuery()
            ->getResult();
    }

    public function findAllBooksA(): array
    {
        return $this->findLibrosGeneral()
            ->where("e.nombre NOT LIKE :a")
            ->setParameter("a", "%a%")
            ->getQuery()
            ->getResult();
    }

    public function findAllBooksOneAutor(): array
    {
     return $this->findLibrosGeneral()
         ->where("SIZE(l.autores) = 1")
         ->getQuery()
         ->getResult();
    }

    public function findAllOrderTitles(): array
    {
        return  $this->findLibrosGeneral()
            ->select("l, a")
            ->orderBy("l.titulo")
            ->join("l.autores", "a")
            ->getQuery()
            ->getResult();
    }


    public function listarLibrosAlfabetico() : array
    {
        return $this->createQueryBuilder('l')
            ->select('l')
            ->orderBy('l.titulo', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function save()
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Libro $libro)
    {
        $this->getEntityManager()->remove($libro);
    }
    public function add(Libro $libro)
    {
        $this->getEntityManager()->persist($libro);
    }
}