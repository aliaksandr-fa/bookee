<?php declare(strict_types=1);

namespace Bookee\UI\Api\Scheduling;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class HealthCheckController
 *
 * @package Bookee\UI\Api\Scheduling
 */
class HealthCheckController extends AbstractController
{
    #[Route(
        '/health-check',
        name: 'scheduling.health-check',
        methods: ['GET']
    )]
    public function index(): Response
    {
        return new JsonResponse(['rand' => rand(), 'service' => 'scheduling']);
    }
}