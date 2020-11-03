<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    public function getBooks($value)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM books 
        WHERE  name like "%":value"%" or author like "%":value"%"
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['value' => $value]);

        // returns an array of arrays (i.e. a raw data set)
        return ($stmt->fetchAll());

    }
    public function findBook($startingValue,$endingValue)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM books LIMIT $endingValue OFFSET $startingValue";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)

        return ($stmt->fetchAll());
    }

    // /**
    //  * @return Books[] Returns an array of Books objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Books
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
