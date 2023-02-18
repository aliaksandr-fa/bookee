<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling\Types;

use Bookee\Domain\Scheduling\TripId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;


class TripIdType extends GuidType
{
    public const NAME = 'scheduling_trip_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof TripId ? $value->value() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new TripId($value) : null;
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