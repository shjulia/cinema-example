<?php

declare(strict_types=1);

namespace App\Model\Movie\Entity\Schedule;

use App\Model\Movie\Entity\Movie\Movie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="schedule")
 */
class Schedule
{
    /**
     * @ORM\Column(type="schedule_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $weekNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private int $weekDay;

    /**
     * @var Collection|ArrayCollection|MovieList[]
     * @ORM\OneToMany(targetEntity="MovieList", mappedBy="schedule", orphanRemoval=true, cascade={"persist"})
     */
    private Collection $movieList;

    public function __construct(Id $id, int $weekNumber, int $weekDay)
    {
        $this->id = $id;
        $this->weekNumber = $weekNumber;
        $this->weekDay = $weekDay;
        $this->movieList = new ArrayCollection();
    }

    public function addMovie(Movie $movie, Time $time): void
    {
        $this->movieList->add(
            new MovieList(
                $movie,
                $this,
                $time
            )
        );
    }
}