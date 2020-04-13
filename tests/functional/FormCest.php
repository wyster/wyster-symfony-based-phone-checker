<?php declare(strict_types=1);

namespace Test;

use App\Phone\PhoneNumber;

class FormCest
{
    private const VALID_PHONE = '+7-905-5559-643';
    private const INVALID_PHONE = '905-5559-643';

    public function tryToTest(FunctionalTester $I): void
    {
        $I->amOnPage('/');
    }

    public function tryToTestWithValidPhone(FunctionalTester $I): void
    {
        $phone = self::VALID_PHONE;
        $data = ['timezone' => 3, 'country' => 'Россия', 'region' => null, 'phone' => (new PhoneNumber($phone))->getPhone()];
        $I->haveInDatabase('phone', $data);
        $I->sendAjaxPostRequest('/', ['phone' => $phone]);
        $I->seeResponseCodeIs(200);
        $content = $I->grabPageSource();
        $resultData = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        ksort($data);
        ksort($resultData);
        $I->assertArrayHasKey('info', $resultData);
        ksort($resultData['info']);
        $I->assertSame($data, $resultData['info']);
        $I->assertArrayHasKey('messages', $resultData);
        $I->assertCount(0, $resultData['messages']);
    }

    public function tryToTestWithInValidPhone(FunctionalTester $I): void
    {
        $phone = self::INVALID_PHONE;
        $I->sendAjaxPostRequest('/', ['phone' => $phone]);
        $I->seeResponseCodeIs(200);
        $content = $I->grabPageSource();
        $resultData = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $I->assertArrayHasKey('messages', $resultData);
        $I->assertCount(1, $resultData['messages']);
        $I->assertSame('Номер телефона указан неверно либо он не валиден', $resultData['messages'][0]);
    }
}
