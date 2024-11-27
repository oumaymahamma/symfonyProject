<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Recherche des articles par nom partiel
     *
     * @param string $name
     * @return Article[] Returns an array of Article objects
     */
    public function findByNameLike(string $name): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('a.name', 'ASC') // Tri par ordre alphabétique
            ->getQuery()
            ->getResult();
    }

    // Exemples déjà présents (vous pouvez les laisser ou les supprimer si inutilisés)

    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
