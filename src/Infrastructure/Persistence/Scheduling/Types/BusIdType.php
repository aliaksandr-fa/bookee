<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling\Types;

use Bookee\Domain\Scheduling\Bus\BusId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

/**
 * Class BusIdType
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling\Types
 */
class BusIdType extends GuidType
{
    public const NAME = 'scheduling_bus_bus_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof BusId ? $value->value() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new BusId($value) : null;
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