<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Navigation;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Navigation\RoutesRepository;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class RoutesRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Navigation
 */
class RoutesRepositoryDoctrine implements RoutesRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function all(): array
    {
        return $this->entityManager->getRepository(Route::class)->findAll();
    }

    public function save(Route $route): void
    {
        $this->entityManager->persist($route);
        $this->entityManager->flush();
    }
}