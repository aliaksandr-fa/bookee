<?php declare(strict_types=1);

namespace Bookee\Tests\Unit\Domain\Booking\Passenger;


use Bookee\Domain\Booking\Passenger\Name;
use Bookee\Domain\Booking\Passenger\Phone;
use PHPUnit\Framework\TestCase;

/**
 * Class NameTest
 *
 * @package Bookee\Tests\Unit\Domain\Booking\Passenger
 */
class NameTest extends TestCase
{
    /**
     * @test
     */
    public function Should_ThrowException_When_FirstNameIsEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Firstname cannot be empty.");

        new Name('');
    }

    /**
     * @test
     * @dataProvider getNamesToStringifyDataProvider
     */
    public function Should_Stringify_When_CastedToString(string $stringified, Name $name)
    {
        $this->assertEquals($stringified, $name . "");
    }

    public function getNamesToStringifyDataProvider(): array
    {
        return [
            ["A", new Name("A")],
            ["A B", new Name("A", "B")],
            ["A", new Name("A", "")]
        ];
    }

}