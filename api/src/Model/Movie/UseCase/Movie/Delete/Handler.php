<?php

declare(strict_types=1);

namespace App\Model\Movie\UseCase\Movie\Delete;

use App\Model\Flusher;
use App\Model\Movie\Entity\Genre\GenreRepository;
use App\Model\Movie\Entity\Movie\Id;
use App\Model\Movie\Entity\Movie\MovieRepository;

class Handler
{
    /**
     * @var MovieRepository
     */
    private MovieRepository $movieRepository;
    /**
     * @var Flusher
     */
    private Flusher $flusher;

    public function __construct(MovieRepository $movieRepository, Flusher $flusher)
    {
        $this->movieRepository = $movieRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $movie = $this->movieRepository->get(new Id($command->id));
        $this->movieRepository->remove($movie);
        $this->flusher->flush();
    }
}