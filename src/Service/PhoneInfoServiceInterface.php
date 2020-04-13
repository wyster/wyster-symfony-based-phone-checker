<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\PhoneInterface;
use App\Phone\PhoneNumberInterface;

interface PhoneInfoServiceInterface
{
    public function get(PhoneNumberInterface $phoneNumber): PhoneInterface;
}
