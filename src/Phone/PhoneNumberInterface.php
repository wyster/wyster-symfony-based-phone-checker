<?php declare(strict_types=1);

namespace App\Phone;

interface PhoneNumberInterface
{
    public function getPhone(): string;
}
