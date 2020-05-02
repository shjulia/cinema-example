<?php

declare(strict_types=1);

namespace App\Model\Movie\Entity\Movie;

use App\Model\Movie\Entity\Genre\Genre;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="movies")
 */
class Movie
{
    /**
     * @ORM\Column(type="movie_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Movie\Entity\Genre\Genre", inversedBy="movie")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private Genre $genre;

    public function __construct(
        Id $id,
        string $title,
        Genre $genre
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
    }

    public function edit(string $title, Genre $genre): void
    {
        $this->title = $title;
        $this->genre = $genre;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }
}