<?php

declare(strict_types=1);

namespace App\Model\Movie\UseCase\Movie\Edit;

use App\Model\Flusher;
use App\Model\Movie\Entity\Genre\GenreRepository;
use App\Model\Movie\Entity\Movie\Id;
use App\Model\Movie\Entity\Movie\MovieRepository;
use Doctrine\ORM\EntityNotFoundException;

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
    /**
     * @var GenreRepository
     */
    private GenreRepository $genreRepository;

    public function __construct(MovieRepository $movieRepository, GenreRepository $genreRepository, Flusher $flusher)
    {
        $this->movieRepository = $movieRepository;
        $this->flusher = $flusher;
        $this->genreRepository = $genreRepository;
    }

    public function handle(Command $command): void
    {
        $movie = $this->movieRepository->get(new Id($command->getId()));

        try {
            $genre = $this->genreRepository->get($command->genre);
        } catch (EntityNotFoundException $e) {
            throw new \DomainException($e->getMessage());
        }

        $movie->edit($command->title, $genre);
        $this->flusher->flush();
    }
}