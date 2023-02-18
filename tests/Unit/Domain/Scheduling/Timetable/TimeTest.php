<?php declare(strict_types=1);

namespace Bookee\Tests\Unit\Domain\Scheduling\Timetable;

use Bookee\Domain\Scheduling\Timetable\Time;
use PHPUnit\Framework\TestCase;


/**
 * Class TimeTest
 *
 * @package Bookee\Tests\Unit\Domain\Scheduling\Timetable
 */
class TimeTest extends TestCase
{
    /**
     * @test
     */
    public function Should_ThrowException_When_UsedNegativeSeconds()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument should be a positive integer.');

        new Time(-1);
    }

    /**
     * @test
     */
    public function Should_ResetTime_When_PassedMoreSecondsThanDayHas()
    {
        $overflowedTimeInSeconds = 24 * 60 * 60 + 1;
        $time = new Time($overflowedTimeInSeconds);

        $this->assertEquals(1, $time->seconds());

        $overflowedTimeInSeconds = (24 * 60 * 60) * 2 - 1;
        $time = new Time($overflowedTimeInSeconds);

        $this->assertEquals((24 * 60 * 60) - 1, $time->seconds());
    }

    /**
     * @test
     * @return void
     */
    public function Should_ThrowException_When_PassedInvalidTimeString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to parse the time.');

        Time::fromString('24:211');
    }

    /**
     * @test
     * @dataProvider createFromStringDataProvider
     */
    public function Should_CreateCorrectTime_When_TimeStringAndFormatAreCorrect(string $formatted, string $format, Time $expected)
    {
        $time = Time::fromString($formatted, $format);

        $this->assertEquals($expected->seconds(), $time->seconds());
    }

    /**
     * @test
     * @dataProvider formatDataProvider
     */
    public function Should_FormatTime_When_TimeFormatIsCorrect(Time $time, string $format, string $formatted)
    {
        $this->assertEquals($formatted, $time->format($format));
    }

    /**
     * @test
     * @dataProvider getHourDataProvider
     */
    public function Should_ReturnValidNumberOfHours_When_TimeIsValid(Time $time, int $hours)
    {
        $this->assertEquals($hours, $time->hours());
    }

    /**
     * @test
     * @dataProvider getMinutesDataProvider
     */
    public function Should_ReturnValidNumberOfMinutes_When_TimeIsValid(Time $time, int $minutes)
    {
        $this->assertEquals($minutes, $time->minutes());
    }

    public function createFromStringDataProvider(): array
    {
        return [
            ['00:00', 'H:i', new Time(0)],
            ['00:01', 'H:i', new Time(1 * 60)],
            ['24:00', 'H:i', new Time(24 * 60 * 60)],
            ['23:59', 'H:i', new Time(24 * 60 * 60 - 1 * 60)]
        ];
    }

    public function formatDataProvider(): array
    {
        return [
            [Time::fromString('23:15'), 'H:i', '23:15'],
            [Time::fromString('23:15'), 'H', '23'],
            [Time::fromString('23:15'), 'i', '15'],
            [Time::fromString('23:15'), 'h:i:s', '11:15:00'],
            [Time::fromString('00:00'), 'h a', '12 am'],
            [Time::fromString('00:00'), '', '']
        ];
    }

    public function getHourDataProvider(): array
    {
        return [
            [Time::fromString('00:00'), 0],
            [Time::fromString('00:59'), 0],
            [Time::fromString('23:59'), 23],
            [Time::fromString('24:00'), 0]
        ];
    }

    public function getMinutesDataProvider(): array
    {
        return [
            [Time::fromString('00:00'), 0],
            [Time::fromString('00:59'), 59],
            [Time::fromString('23:59'), 59],
            [Time::fromString('24:00'), 0]
        ];
    }
}