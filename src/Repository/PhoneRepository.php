<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Phone;
use App\Phone\PhoneNumberInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Phone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phone[]    findAll()
 * @method Phone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phone::class);
    }

    public function findPhone(PhoneNumberInterface $phoneNumber): ?Phone
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.phone = :val')
            ->setParameter('val', $phoneNumber->getPhone())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
