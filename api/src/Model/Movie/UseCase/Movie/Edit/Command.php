<?php

declare(strict_types=1);

namespace App\Model\Movie\UseCase\Movie\Edit;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    private string $id;

    /**
     * @Assert\NotBlank()
     */
    public string $title = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $genre = '';

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}