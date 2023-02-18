<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;


/**
 * Class TripStatus
 *
 * @package Bookee\Domain\Scheduling
 */
enum TripStatus: string
{
    case DRAFT = 'draft';
    case SCHEDULED = 'scheduled';
    case SUSPENDED = 'suspended';
    case CANCELED = 'canceled';

    public function isDraft(): bool
    {
        return $this === self::DRAFT;
    }

    public function isScheduled(): bool
    {
        return $this === self::SCHEDULED;
    }

    public function isSuspended(): bool
    {
        return $this === self::SUSPENDED;
    }
}