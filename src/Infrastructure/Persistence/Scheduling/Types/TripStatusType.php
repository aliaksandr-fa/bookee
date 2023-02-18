<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling\Types;

use Bookee\Domain\Scheduling\TripStatus;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;


/**
 * Class TripStatusType
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling\Types
 */
class TripStatusType extends StringType
{
    public const NAME = 'scheduling_trip_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof TripStatus ? $value->value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? TripStatus::from($value) : null;
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