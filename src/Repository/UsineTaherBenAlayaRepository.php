<?php
namespace App\Repository;

use App\Entity\UsineNomPrenom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsineNomPrenom>
 *
 * @method UsineNomPrenom|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsineNomPrenom|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsineNomPrenom[]    findAll()
 * @method UsineNomPrenom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsineNomPrenomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsineNomPrenom::class);
    }

    public function save(UsineNomPrenom $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UsineNomPrenom $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Exemple de méthode personnalisée (décommenter / adapter si besoin)
    /*
    public function findByNom(string $nom): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.nom = :nom')
            ->setParameter('nom', $nom)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneByEmail(string $email): ?UsineNomPrenom
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
    */
}