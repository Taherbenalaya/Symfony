<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère tous les livres avec leur auteur (join pour éviter N+1)
     *
     * @return Book[]
     */
    public function findAllWithAuthor(): array
    {
        return $this->createQueryBuilder('b')
            ->addSelect('a')
            ->leftJoin('b.author', 'a')
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les livres pour un auteur donné
     *
     * @param int $authorId
     * @return Book[]
     */
    public function findByAuthorId(int $authorId): array
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $authorId)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Exemple : recherche par titre (optionnel)
     *
     * @param string $title
     * @return Book[]
     */
    public function findByTitle(string $title): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.title LIKE :t')
            ->setParameter('t', '%'.$title.'%')
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
