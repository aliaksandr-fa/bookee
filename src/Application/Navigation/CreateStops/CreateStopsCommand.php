<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\CreateStops;

use Symfony\Component\Validator\Constraints as Assert;
use Bookee\Infrastructure\Bus\Command\Command;


/**
 * Class CreateStopsCommand
 *
 * @package Bookee\Application\Navigation\CreateStops
 */
class CreateStopsCommand implements Command
{
    #[Assert\All([
        new Assert\Collection(
            fields: [
                'title' => [
                    new Assert\NotBlank(),
                    new Assert\Length(max: 150)
                ],
                'location' => new Assert\Collection(
                    fields: [
                        'latitude' => new Assert\Type('float'),
                        'longitude' => new Assert\Type('float')
                    ]
                )
            ]
        )
    ])]
    public array $stops;

    public function __construct(array $stops = [])
    {
        $this->stops = $stops;
    }
}