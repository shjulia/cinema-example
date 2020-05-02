<?php

declare(strict_types=1);

namespace App\Model\Movie\UseCase\Movie\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public string $title = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $genre = '';
}