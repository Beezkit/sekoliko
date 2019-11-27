<?php

namespace App\Repository;

use App\Entity\Room;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function findBySchoolYear(User $user)
    {
        $list = $this->createQueryBuilder('a')
            ->where('a.deletedAt is NULL')
            ->andWhere('a.etsName = :ets')
            ->setParameter('ets', $user->getEtsName())
            ->getQuery()
            ->getResult();

        return $list;
    }
}
