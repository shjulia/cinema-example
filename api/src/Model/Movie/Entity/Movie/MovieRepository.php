<?php

declare(strict_types=1);

namespace App\Model\Movie\Entity\Movie;

use App\Model\Work\Entity\Projects\Task\Task;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class MovieRepository
{
    private EntityManagerInterface $em;

    /**
     * @var EntityRepository|ObjectRepository
     */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Movie::class);
    }

    /**
     * @param Id $id
     * @return Movie
     * @throws EntityNotFoundException
     */
    public function get(Id $id): Movie
    {
        /** @var Movie $movie */
        if (!$movie = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Movie is not found.');
        }
        return $movie;
    }

    public function add(Movie $movie): void
    {
        $this->em->persist($movie);
    }

    public function remove(Movie $movie): void
    {
        $this->em->remove($movie);
    }
}