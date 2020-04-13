<?php declare(strict_types=1);

namespace App\DaData;

use App\Entity\PhoneInterface;
use App\Phone\PhoneNumberInterface;

final class Phone implements PhoneInterface
{
    private string $country;
    private ?string $region;
    private int $timezone;
    private PhoneNumberInterface $phone;

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getTimezone(): int
    {
        return $this->timezone;
    }

    public function setTimezone(int $timezone): void
    {
        $this->timezone = $timezone;
    }

    public function getPhone(): PhoneNumberInterface
    {
        return $this->phone;
    }

    public function setPhone(PhoneNumberInterface $phone): void
    {
        $this->phone = $phone;
    }
}
