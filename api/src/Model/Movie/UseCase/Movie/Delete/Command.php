<?php

declare(strict_types=1);

namespace App\Model\Movie\UseCase\Movie\Delete;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id;
}