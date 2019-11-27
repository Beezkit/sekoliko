<?php

namespace App\Repository;

use App\Entity\ClassRoom;
use App\Entity\Section;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClassRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassRoom[]    findAll()
 * @method ClassRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassRoom::class);
    }

    /**
     * @param User    $user
     * @param Section $section
     *
     * @return ClassRoom[] Returns an array of ClassRoom objects
     */
    public function findBySchoolYear(User $user, Section $section)
    {
        return $this->createQueryBuilder('c')
            ->where('c.deletedAt is NULL')
            ->andWhere('c.etsName = :ets')
            ->andWhere('c.section= :section')
            ->andWhere('c.schoolYear = :year')
            ->setParameter('ets', $user->getEtsName())
            ->setParameter('section', $section)
            ->setParameter('year', $user->getSchoolYear())
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
