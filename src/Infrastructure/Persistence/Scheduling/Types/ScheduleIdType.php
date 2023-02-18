<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling\Types;

use Bookee\Domain\Scheduling\ScheduleId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;


/**
 * Class ScheduleIdType
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling\Types
 */
class ScheduleIdType extends GuidType
{
    public const NAME = 'scheduling_schedule_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof ScheduleId ? $value->value() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new ScheduleId($value) : null;
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