<?php declare(strict_types=1);

namespace App\DaData;

use App\Entity\PhoneInterface;

interface ApiInterface
{
    public function getPhoneInfo(string $phone): PhoneInterface;
}
