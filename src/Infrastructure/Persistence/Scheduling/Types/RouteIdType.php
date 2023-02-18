<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling\Types;

use Bookee\Domain\Scheduling\RouteId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;


class RouteIdType extends GuidType
{
    public const NAME = 'scheduling_route_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof RouteId ? $value->value() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new RouteId($value) : null;
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