<?php

declare(strict_types=1);

namespace App\Model\Movie\UseCase\Movie\Edit;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id;

    /**
     * @Assert\NotBlank()
     */
    public string $title = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $genre = '';

    public function __construct(string $id, string $title, string $genre)
    {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
    }
}