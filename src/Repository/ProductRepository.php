<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function countAll()
    {
    return $this->createQueryBuilder('product')
    ->select('COUNT(product) as nbProducts')
    ->getQuery()
    ->getFirstResult();
    }

    // // /**
    // //  * @return Product[] Returns an array of Product objects
    // //  */
    // /*
    // public function findByCategory($id)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.categories = :id')
    //         ->setParameter('id', $id)
    //         ->orderBy('p.id', 'ASC')
    //         ->setMaxResults(60)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    // */

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

    // searchbar
    // #########
    public function search($filtres) {
        $query = $this->createQueryBuilder('p')->join('p.categories', 'category');
        if(!empty($filtres['searchBar'])) {
            $query->where('p.title LIKE :search')
            ->orWhere('p.description LIKE :search')
            ->orWhere('category.name LIKE :search')
            ->setParameter('search', '%'.$filtres['searchBar'].'%');
        }
        
        return $query->getQuery()->getResult();
    }

}
