<?php declare(strict_types=1);

namespace App\Phone;

use InvalidArgumentException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

final class PhoneNumber implements PhoneNumberInterface
{
    private string $phone;

    public function __construct(string $phone)
    {
        $phone = $this->filter($phone);
        if (!$this->phoneIsValid($phone)) {
            throw new InvalidArgumentException('Invalid phone');
        }
        $this->phone = preg_replace('/\D+/', '', $phone);
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    private function filter(string $phone): string
    {
        return ltrim($phone, '+');
    }

    private function phoneIsValid(string $phone): bool
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $preparedPhone = '+' . ltrim($phone, '+');
            $phoneInfo = $phoneUtil->parse($preparedPhone);

            return $phoneUtil->isValidNumber($phoneInfo);
        } catch (NumberParseException $e) {
        }

        return false;
    }
}
