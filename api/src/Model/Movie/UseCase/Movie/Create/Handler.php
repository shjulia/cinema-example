<?php

declare(strict_types=1);

namespace App\Model\Movie\UseCase\Movie\Create;

use App\Model\Flusher;
use App\Model\Movie\Entity\Genre\GenreRepository;
use App\Model\Movie\Entity\Movie\Id;
use App\Model\Movie\Entity\Movie\Movie;
use App\Model\Movie\Entity\Movie\MovieRepository;
use Doctrine\ORM\EntityNotFoundException;
use Ramsey\Uuid\Uuid;

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
        try {
            $genre = $this->genreRepository->get($command->genre);
        } catch (EntityNotFoundException $e) {
            throw new \DomainException($e->getMessage());
        }

        $movie = new Movie(Id::next(), $command->title, $genre);
        $this->movieRepository->add($movie);
        $this->flusher->flush();
    }
}