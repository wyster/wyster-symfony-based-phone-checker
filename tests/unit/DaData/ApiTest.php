<?php declare(strict_types=1);

namespace Test\DaData;

use App\DaData\Api;
use App\DaData\ApiInterface;
use App\DaData\Phone;
use App\Phone\PhoneNumber;
use Codeception\Test\Unit;
use Exception;
use Http\Mock\Client;
use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Test\UnitTester;

final class ApiTest extends Unit
{
    private const PHONE = '+7-905-5559-643';

    protected UnitTester $tester;

    public function testGetPhoneInfoSuccess(): void
    {
        $phone = self::PHONE;
        $client = new Client();
        $params = ['timezone' => 'UTC+3', 'country' => 'Россия', 'region' => null, 'phone' => $phone];
        $client->addResponse($this->createResponse(200, [$params]));
        $api = $this->createApiInstance($client);
        $result = $api->getPhoneInfo(new PhoneNumber($phone));
        $this->assertInstanceOf(Phone::class, $result);
    }

    public function testGetPhoneInfoError(): void
    {
        $phone = self::PHONE;
        $this->expectException(Exception::class);
        $client = new Client();
        $params = ['timezone' => 'UTC+3', 'country' => 'Россия', 'region' => null, 'phone' => $phone];
        $client->addResponse($this->createResponse(500, [$params]));
        $api = $this->createApiInstance($client);
        $api->getPhoneInfo(new PhoneNumber($phone));
    }

    private function createResponse(int $status, array $data = []): ResponseInterface
    {
        return new Response($status, [], json_encode($data, JSON_THROW_ON_ERROR));
    }

    private function createApiInstance(Client $client): ApiInterface
    {
        return new Api(
            $client,
            $this->tester->grabService(RequestFactoryInterface::class),
            $this->tester->grabService(StreamFactoryInterface::class),
        );
    }
}
