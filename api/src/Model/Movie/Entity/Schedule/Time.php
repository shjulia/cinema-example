<?php

declare(strict_types=1);

namespace App\Model\Movie\Entity\Schedule;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Time
 * @ORM\Embeddable
 * @package App\Model\Schedule\Entity\Schedule
 */
class Time
{
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $start;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $end;

    public function __construct(\DateTimeImmutable $startTime, \DateTimeImmutable $endTime)
    {
        $this->start = $startTime;
        $this->end = $endTime;
    }
}