<?php declare(strict_types=1);

namespace App\DaData;

use App\Entity\PhoneInterface;
use App\Phone\PhoneNumberInterface;

interface ApiInterface
{
    public function getPhoneInfo(PhoneNumberInterface $phoneNumber): PhoneInterface;
}
