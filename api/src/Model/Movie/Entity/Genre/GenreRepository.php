<?php

declare(strict_types=1);

namespace App\Model\Movie\Entity\Genre;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class GenreRepository
{
    private EntityManagerInterface $em;

    /**
     * @var EntityRepository|ObjectRepository
     */
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Genre::class);
    }

    /**
     * @param string $id
     * @return Genre
     * @throws EntityNotFoundException
     */
    public function get(string $id): Genre
    {
        /** @var Genre $genre */
        if (!$genre = $this->repo->find($id)) {
            throw new EntityNotFoundException('Genre is not found.');
        }
        return $genre;
    }
}