<?php declare(strict_types=1);

namespace App\DBAL;

use App\Phone\PhoneNumber;
use App\Phone\PhoneNumberInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class PhoneType extends Type
{
    private const TYPE = Types::STRING;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): PhoneNumberInterface
    {
        return new PhoneNumber($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof PhoneNumberInterface) {
            return $value->getPhone();
        }

        return null;
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
