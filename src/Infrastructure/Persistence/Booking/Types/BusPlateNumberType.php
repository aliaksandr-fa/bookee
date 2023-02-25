<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking\Types;


use Bookee\Domain\Booking\Bus\BusPlateNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

/**
 * Class BusPlateNumber
 *
 * @package Bookee\Infrastructure\Persistence\Booking\Types
 */
class BusPlateNumberType extends StringType
{
    public const NAME = 'booking_bus_plate_number';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof BusPlateNumber ? $value->number() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new BusPlateNumber($value) : null;
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