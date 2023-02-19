<?php declare(strict_types=1);

namespace Bookee\Domain\Shared;

use Ramsey\Uuid\Uuid as RamseyUuid;;
use Webmozart\Assert\Assert;


/**
 * Class Uuid
 *
 * @package Bookee\Domain\Shared
 */
class Uuid implements \Stringable
{
    private string $value;

    public final function __construct(string $value)
    {
        Assert::uuid($value);
        $this->value = $value;
    }

    public static function next(): static
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
