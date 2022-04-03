<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\PhoneValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Customer $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Customer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

  /**
   * @param array|null $parameters
   * @return QueryBuilder
   */
    public function findCustomersPhoneNumbers(array $parameters = null) : QueryBuilder
    {
      $qb = $this->createQueryBuilder('c');
      $query = $qb->select(
        'c.phone',
        'c.state',
        'c.name',
        'p.countryCode',
        'p.countryName',
        'p.regex'
      )
        ->join(PhoneValidator::class, 'p')
        ->where($qb->expr()->eq(
          $qb->expr()->substring('c.phone', 2, 3),
          $qb->expr()->substring('p.countryCode', 2, 4)
        ));

      if ($parameters) {
        if (isset($parameters['country']) && $parameters['country']) {
          $query->andWhere('p.countryName = :countryName')
            ->setParameter('countryName', $parameters['country']);
        }

        if (isset($parameters['state']) && in_array($parameters['state'], ["0", "1"])) {
          $query->andWhere('c.state = :state')
            ->setParameter('state', $parameters['state']);
        }
      }

      return $query;
    }
}
