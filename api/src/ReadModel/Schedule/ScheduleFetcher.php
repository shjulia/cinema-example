<?php

declare(strict_types=1);

namespace App\ReadModel\Schedule;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class ScheduleFetcher
{
    /**
     * @var Connection
     */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findSchedule(int $weekNumber)
    {
        $schedulesQuery = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('schedule')
            ->where('week_number = :weekNumber')
            ->setParameter(':weekNumber', $weekNumber)
            ->execute()->fetchAll(FetchMode::ASSOCIATIVE);
        $schedules = [];

        foreach ($schedulesQuery as $schedule) {
            $schedules[$schedule['id']] = $schedule;
        }

        $movieLists = $this->connection->createQueryBuilder()
            ->select(
                'sml.id as movie_list_id',
                'time_start',
                'time_end',
                'schedule_id',
                'm.id as movie_id',
                'm.title',
                'g.title as genre'
            )
            ->from('schecdule_movie_list', 'sml')
            ->where('schedule_id IN (:scheduleIds)')
            ->setParameter(':scheduleIds', array_keys($schedules), Connection::PARAM_STR_ARRAY)
            ->leftJoin('sml', 'movies', 'm', 'm.id = sml.movie_id')
            ->leftJoin('m', 'genres', 'g', 'm.genre_id = g.id')
            ->execute()->fetchAll(FetchMode::ASSOCIATIVE);

        foreach ($movieLists as $movieList) {
            $schedules[$movieList['schedule_id']]['movieList'][] = $movieList;
        }

        return $schedules;
    }
}