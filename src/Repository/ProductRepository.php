<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Permet de recupéré les produits plus chére qu'un certain montant
     */
    public function findAllGreatherThanPrice($price): array
    {
        // SELECT * FROM product WHERE price > 500

        // SELECT id, name, description, slug FROM product p 
        // WHERE p.proce > 50000
        // ORDER BY p.price ASC
        // LIMIT 0, 4
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', $price * 100)
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    /**
     * Permet de recupérer le produit le plus chér qu'un certain monyent
     */
    public function findOneGreaterThanPrice($price): ?Product
    {
        $queryBuilder = $this->createQueryBuilder('p')
        ->where('p.price > :price')
        ->setParameter('price', $price * 100)
        ->orderBy('p.price', 'ASC')
        ->getQuery();

        return $queryBuilder->setMaxResults(1)->getOneOrNullResult();
    }

    public function findAll() // ou findAllWithUser() sa evit de surchargé la requete
    {
        $queryBuilder = $this->createQueryBuilder('p')
        // On peut aussi faire un innerJoin()
        ->leftJoin('p.user', 'u')
        ->addSelect('u')
        ->getQuery();

        return $queryBuilder->execute();
    }








    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
