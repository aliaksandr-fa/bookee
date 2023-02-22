<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use Bookee\Domain\Shared\DomainException;

/**
 * Class UnableToScheduleTripException
 *
 * @package Bookee\Domain\Scheduling
 */
class UnableToScheduleTripException extends DomainException
{
    public function __construct(string $message = "Unable to schedule a trip.")
    {
        parent::__construct($message);
    }
}