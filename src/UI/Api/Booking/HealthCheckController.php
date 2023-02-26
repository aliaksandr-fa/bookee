<?php declare(strict_types=1);

namespace Bookee\UI\Api\Booking;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class HealthCheckController
 *
 * @package Bookee\UI\Api\Booking
 */
class HealthCheckController extends AbstractController
{
    #[Route(
        '/health-check',
        name: 'booking.health-check',
        methods: ['GET']
    )]
    public function index(): Response
    {
        return new JsonResponse(['rand' => rand(), 'service' => 'booking']);
    }
}