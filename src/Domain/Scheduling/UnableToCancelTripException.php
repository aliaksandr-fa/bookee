<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use Bookee\Domain\Shared\DomainException;

/**
 * Class UnableToCancelTripException
 *
 * @package Bookee\Domain\Scheduling
 */
class UnableToCancelTripException extends DomainException
{
    public function __construct(string $message = "Unable to cancel a trip.")
    {
        parent::__construct($message);
    }
}