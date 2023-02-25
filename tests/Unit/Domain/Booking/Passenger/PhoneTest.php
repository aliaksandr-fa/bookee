<?php declare(strict_types=1);

namespace Bookee\Tests\Unit\Domain\Booking\Passenger;

use Bookee\Domain\Booking\Passenger\Phone;
use PHPUnit\Framework\TestCase;


/**
 * Class PhoneTest
 *
 * @package Bookee\Tests\Unit\Domain\Booking\Passenger
 */
class PhoneTest extends TestCase
{
    /**
     * @test
     */
    public function Should_ThrowException_When_PhoneIsEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Phone cannot be empty.');

        new Phone('');
    }
}