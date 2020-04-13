<?php declare(strict_types=1);

namespace App\Entity;

use App\Phone\PhoneNumberInterface;

interface PhoneInterface
{
    public function getCountry(): string;

    public function getRegion(): ?string;

    public function getTimezone(): int;

    public function getPhone(): PhoneNumberInterface;
}
