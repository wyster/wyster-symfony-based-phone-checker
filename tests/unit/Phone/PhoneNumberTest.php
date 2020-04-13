<?php declare(strict_types=1);

namespace Test\DaData;

use App\Phone\PhoneNumber;
use App\Phone\PhoneNumberInterface;
use Codeception\Test\Unit;
use Exception;
use Test\UnitTester;

final class PhoneNumberTest extends Unit
{
    private const VALID_PHONE = '+7-905-5559-643';
    private const INVALID_PHONE = '905-5559-643';

    protected UnitTester $tester;

    public function testValidPhone(): void
    {
        $phone = new PhoneNumber(self::VALID_PHONE);
        $this->assertInstanceOf(PhoneNumber::class, $phone);
        $this->assertInstanceOf(PhoneNumberInterface::class, $phone);
    }

    public function testInvalidPhone(): void
    {
        $this->expectException(Exception::class);
        new PhoneNumber(self::INVALID_PHONE);
    }
}
