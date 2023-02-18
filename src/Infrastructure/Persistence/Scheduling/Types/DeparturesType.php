<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling\Types;

use Bookee\Domain\Scheduling\Timetable\Time;
use Bookee\Domain\Scheduling\Timetable\Departures;
use Bookee\Domain\Scheduling\Timetable\TimetableId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Types\SimpleArrayType;


/**
 * Class DeparturesType
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling\Types
 */
class DeparturesType extends SimpleArrayType
{
    public const NAME = 'scheduling_departures';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        $value = $value instanceof Departures ? $value->flatten() : $value;

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $value = parent::convertToPHPValue($value, $platform);

        $times = array_map(fn($seconds) => new Time(intval($seconds)), $value);

        return !empty($value) ? new Departures(...$times) : null;
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