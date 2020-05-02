<?php

declare(strict_types=1);

namespace App\Model\Movie\Entity\Schedule;

use App\Model\Movie\Entity\Movie\Movie;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="schecdule_movie_list")
 */
class MovieList
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private string $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Movie\Entity\Movie\Movie")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="cascade")
     */
    private Movie $movie;

    /**
     * @ORM\ManyToOne(targetEntity="Schedule", inversedBy="movieList")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", onDelete="cascade")
     */
    private Schedule $schedule;

    /**
     * @ORM\Embedded(class="Time")
     */
    private Time $time;

    public function __construct(
        Movie $movie,
        Schedule $schedule,
        Time $time
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->movie = $movie;
        $this->schedule = $schedule;
        $this->time = $time;
    }
}