<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\CreateRoute;

use Bookee\Infrastructure\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class CreateRouteCommand
 *
 * @package Bookee\Application\Navigation\CreateRoute
 */
class CreateRouteCommand implements Command
{
    #[Assert\Length(max: 150)]
    public string $routeName;

    #[Assert\Type('integer')]
    public int $routeNumber;

    #[Assert\Count(min: 2)]
    #[Assert\All([
        new Assert\Collection(
            fields: [
                'id' => new Assert\Uuid(),
                'eta' => [
                    new Assert\Type('integaer'),
                    new Assert\NotBlank(message: "Eta shouldn't be blank.")
                ],
            ]
        )
    ])]
    public array $stops;

    public function __construct(string $routeName, int $routeNumber)
    {
        $this->routeName = $routeName;
        $this->routeNumber = $routeNumber;
    }
}