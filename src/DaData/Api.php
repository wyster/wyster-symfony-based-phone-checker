<?php declare(strict_types=1);

namespace App\DaData;

use Exception;
use Laminas\Hydrator\ClassMethodsHydrator;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use App\Entity\PhoneInterface;

final class Api implements ApiInterface
{
    private const URL = 'https://cleaner.dadata.ru/api/v1/clean/phone';

    private ClientInterface $httpClient;
    private RequestFactoryInterface $httpRequestFactory;
    private StreamFactoryInterface $streamFactory;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $httpRequestFactory, StreamFactoryInterface $streamFactory)
    {
        $this->httpClient = $httpClient;
        $this->httpRequestFactory = $httpRequestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function getPhoneInfo(string $phone): PhoneInterface
    {
        $request = $this->httpRequestFactory->createRequest('POST', self::URL);

        $request = $request->withHeader('Content-Type', 'application/json')
            ->withHeader('Authorization', sprintf('Token %s', getenv('DADATA_API_KEY')))
            ->withHeader('X-Secret', getenv('DADATA_SECRET_KEY'));
        $bodyStream = $this->streamFactory->createStream(json_encode([$phone], JSON_THROW_ON_ERROR));
        $request = $request->withBody($bodyStream);

        $response = $this->httpClient->sendRequest($request);
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Invalid response', $response->getStatusCode());
        }
        $responseBody = $response->getBody()->__toString();

        $data = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR)[0];

        $data['timezone'] = (int)str_replace('UTC', '', $data['timezone']);

        $hydrator = new ClassMethodsHydrator();
        $entity = new Phone();
        $hydrator->hydrate($data, $entity);

        return $entity;
    }
}
