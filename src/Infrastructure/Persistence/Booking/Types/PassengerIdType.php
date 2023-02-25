<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking\Types;

use Bookee\Domain\Booking\Passenger\PassengerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;


class PassengerIdType extends GuidType
{
    public const NAME = 'booking_passenger_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof PassengerId ? $value->value() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new PassengerId($value) : null;
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
