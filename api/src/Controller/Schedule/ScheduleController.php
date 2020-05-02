<?php

declare(strict_types=1);

namespace App\Controller\Schedule;

use App\ReadModel\Schedule\ScheduleFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    /**
     * @var ScheduleFetcher
     */
    private ScheduleFetcher $scheduleFetcher;

    public function __construct(ScheduleFetcher $scheduleFetcher)
    {
        $this->scheduleFetcher = $scheduleFetcher;
    }

    /**
     * @Route("/schedule/{weekNumber}", methods={"GET"})
     * @param int $weekNumber
     * @return JsonResponse
     */
    public function show(int $weekNumber): JsonResponse
    {
        $schedule = $this->scheduleFetcher->findSchedule($weekNumber);
        return new JsonResponse($schedule, Response::HTTP_OK);
    }
}