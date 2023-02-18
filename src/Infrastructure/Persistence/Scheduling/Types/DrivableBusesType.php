<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling\Types;

use Bookee\Domain\Scheduling\Bus\BusId;
use Bookee\Domain\Scheduling\Driver\DrivableBuses;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\SimpleArrayType;


/**
 * Class DrivableBusesType
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling\Types
 */
class DrivableBusesType extends SimpleArrayType
{
    public const NAME = 'scheduling_driver_drivable_buses';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        $value = $value instanceof DrivableBuses ? $value->getArrayCopy() : $value;

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $value = parent::convertToPHPValue($value, $platform);

        $busIds = array_map(fn($id) => new BusId($id), $value);

        return !empty($value) ? new DrivableBuses(...$busIds) : null;
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