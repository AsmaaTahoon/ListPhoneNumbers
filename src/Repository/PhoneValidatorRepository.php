<?php

namespace App\Repository;

use App\Entity\PhoneValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhoneValidator|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneValidator|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneValidator[]    findAll()
 * @method PhoneValidator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneValidatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhoneValidator::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PhoneValidator $entity, bool $flush = true): void
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
    public function remove(PhoneValidator $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
