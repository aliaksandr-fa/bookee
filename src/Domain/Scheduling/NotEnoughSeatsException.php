<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use Bookee\Domain\Shared\DomainException;


/**
 * Class NotEnoughSeatsException
 *
 * @package Bookee\Domain\Scheduling
 */
class NotEnoughSeatsException extends DomainException
{
    public function __construct(string $message = "Number of .")
    {
        parent::__construct($message);
    }
}