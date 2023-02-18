<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Timetable;


/**
 * Class Time
 *
 * @package Bookee\Domain\Scheduling\Timetable
 */
class Time
{
    public final function __construct(private int $seconds)
    {
        if ($seconds < 0)
        {
            throw new \InvalidArgumentException('Argument should be a positive integer.');
        }

        $this->seconds = $seconds % (24 * 60 * 60);
    }

    public static function fromString($formatted, $format = 'H:i'): Time
    {
        $date = \DateTimeImmutable::createFromFormat($format, $formatted);

        if (!$date) {
            throw new \InvalidArgumentException('Unable to parse the time.');
        }

        return self::fromDateTimeImmutable($date);
    }

    public static function fromDateTimeImmutable(\DateTimeImmutable $dateTime = new \DateTimeImmutable()): Time
    {
        $seconds = $dateTime->getTimestamp() - (new \DateTime('today'))->getTimestamp();

        return new static($seconds);
    }

    public function format($format = 'H:i'): string
    {
        return $this->toDate()->format($format);
    }

    public function seconds(): int
    {
        return $this->seconds;
    }

    public function hours(): int
    {
        return (int) floor($this->seconds / 60 / 60);
    }

    public function minutes(): int
    {
        return (int) floor(($this->seconds - $this->hours() * 60 * 60) / 60);
    }

    private function toDate(): \DateTimeImmutable
    {
        $midnight = (new \DateTimeImmutable('today'));

        return $midnight->setTimestamp($midnight->getTimestamp() + $this->seconds);
    }

    public function equals(Time $other): bool
    {
        return $this->seconds() === $other->seconds();
    }

    public function biggerThan(Time $other): bool
    {
        return $this->seconds() > $other->seconds();
    }
}