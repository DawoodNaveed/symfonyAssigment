<?php

namespace App\Repository;

use App\Entity\OrderBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderBook[]    findAll()
 * @method OrderBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderBookRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderBook::class);
    }

    public function findProcessedOrders($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select books.image,books.name,books.author,books.published_date from books
                inner join order_book where books.id=order_book.book_id_id AND 
                order_book.user_email_id= :id AND order_book.processing=true;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $userId]);

        // returns an array of arrays (i.e. a raw data set)
       return ($stmt->fetchAll());

    }

    public function findunProcessedOrders($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select books.image,books.name,books.author,books.published_date from books
                inner join order_book where books.id=order_book.book_id_id AND 
                order_book.user_email_id= :id AND order_book.processing=false;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $userId]);

        // returns an array of arrays (i.e. a raw data set)
        return ($stmt->fetchAll());

    }

    // /**
    //  * @return OrderBook[] Returns an array of OrderBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderBook
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
