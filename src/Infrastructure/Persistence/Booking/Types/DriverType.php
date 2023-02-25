<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking\Types;

use Bookee\Domain\Booking\Driver\Driver;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;


class DriverType extends StringType
{
    public const NAME = 'booking_driver';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof Driver ? "{$value->name()},{$value->phone()}" : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        list ($name, $phone) = explode(',', $value);

        return new Driver($name, $phone);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
}
