<?php declare(strict_types=1);

namespace Test\Service;

use App\DaData\ApiInterface;
use App\DaData\Phone;
use App\Entity\Phone as PhoneEntity;
use App\Phone\PhoneNumber;
use App\Service\PhoneInfoService;
use App\Service\PhoneInfoServiceInterface;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory as Faker;
use Test\UnitTester;

final class PhoneInfoServiceTest extends Unit
{
    private const PHONE = '+7-905-5559-643';

    protected UnitTester $tester;

    public function testGetMethod(): void
    {
        $phone = new PhoneNumber(self::PHONE);
        $faker = Faker::create('ru_RU');
        $entity = new Phone();
        $entity->setCountry($faker->country);
        $entity->setRegion(null);
        $entity->setTimezone(3);
        $entity->setPhone($phone);
        $apiMock = $this->createMock(ApiInterface::class);
        $apiMock->expects($this->once())->method('getPhoneInfo')->willReturn($entity);

        $service = $this->createService($apiMock);
        // Получение из апи
        $result = $service->get($phone);
        $this->assertInstanceOf(PhoneEntity::class, $result);

        // Получение из бд
        $result = $service->get($phone);
        $this->assertInstanceOf(PhoneEntity::class, $result);
    }

    private function createService(ApiInterface $apiMock): PhoneInfoServiceInterface
    {
        return new PhoneInfoService(
            $this->tester->grabService(EntityManagerInterface::class),
            $apiMock
        );
    }
}
