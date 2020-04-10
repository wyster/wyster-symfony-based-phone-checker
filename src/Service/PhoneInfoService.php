<?php declare(strict_types=1);

namespace App\Service;

use App\DaData\Api;
use App\Entity\Phone;
use App\Entity\PhoneInterface;
use App\Phone\PhoneNumberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Hydrator\ClassMethodsHydrator;

final class PhoneInfoService
{
    private EntityManagerInterface $entityManager;
    private Api $api;

    public function __construct(EntityManagerInterface $entityManager, Api $api)
    {
        $this->api = $api;
        $this->entityManager = $entityManager;
    }

    public function get(PhoneNumberInterface $phoneNumber): PhoneInterface
    {
        $phone = $phoneNumber->getPhone();
        $phoneRepository = $this->entityManager->getRepository(Phone::class);
        if ($phoneRow = $phoneRepository->findPhone($phone)) {
            return $phoneRow;
        }

        $phoneInfo = $this->api->getPhoneInfo($phone);
        $phoneRow = new Phone();
        $phoneRow->setPhone($phoneNumber);

        $hydrator = new ClassMethodsHydrator();
        $hydrator->hydrate($hydrator->extract($phoneInfo), $phoneRow);

        $this->entityManager->persist($phoneRow);
        $this->entityManager->flush();

        return $phoneRow;
    }
}
