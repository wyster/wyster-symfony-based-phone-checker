<?php declare(strict_types=1);

namespace App\Service;

use App\DaData\ApiInterface;
use App\Entity\Phone;
use App\Entity\PhoneInterface;
use App\Phone\PhoneNumberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Hydrator\ClassMethodsHydrator;

final class PhoneInfoService implements PhoneInfoServiceInterface
{
    private EntityManagerInterface $entityManager;
    private ApiInterface $api;

    public function __construct(EntityManagerInterface $entityManager, ApiInterface $api)
    {
        $this->api = $api;
        $this->entityManager = $entityManager;
    }

    public function get(PhoneNumberInterface $phoneNumber): PhoneInterface
    {
        $phoneRepository = $this->entityManager->getRepository(Phone::class);
        if ($phoneRow = $phoneRepository->findPhone($phoneNumber)) {
            return $phoneRow;
        }

        $phoneInfo = $this->api->getPhoneInfo($phoneNumber);
        $phoneRow = new Phone();
        $phoneRow->setPhone($phoneNumber);

        $hydrator = new ClassMethodsHydrator();
        $hydrator->hydrate($hydrator->extract($phoneInfo), $phoneRow);

        $this->entityManager->persist($phoneRow);
        $this->entityManager->flush();

        return $phoneRow;
    }
}
