<?php

namespace App\Repository;

use App\Entity\SchoolYear;
use App\Entity\Section;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    /**
     * SectionRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

    /**
     * @param User $user
     *
     * @return Section[] Returns an array of Section objects
     */
    public function findBySchoolYear(User $user)
    {
        return $this->createQueryBuilder('s')
            ->where('s.deletedAt is NULL')
            ->andWhere('s.etsName = :ets')
            ->innerJoin(SchoolYear::class, 'c')
            ->andWhere(':year MEMBER OF s.schoolYear')
            ->setParameter('ets', $user->getEtsName())
            ->setParameter('year', $user->getSchoolYear())
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
