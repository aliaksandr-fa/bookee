<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking;

use Bookee\Application\Booking\CreateTrip\TripsRepository;
use Bookee\Domain\Booking\Trip;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class TripsRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence
 */
class TripsRepositoryDoctrine implements TripsRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Trip $trip): void
    {
        $this->entityManager->persist($trip);
        $this->entityManager->flush();
    }
}