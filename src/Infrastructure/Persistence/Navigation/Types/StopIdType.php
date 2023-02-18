<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Navigation\Types;

use Bookee\Domain\Navigation\StopId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;


class StopIdType extends GuidType
{
    public const NAME = 'navigation_stop_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof StopId ? $value->value() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return !empty($value) ? new StopId($value) : null;
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