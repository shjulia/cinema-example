<?php

declare(strict_types=1);

namespace App\ReadModel\Movie;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class MovieFetcher
{
    /**
     * @var Connection
     */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string|null $title
     * @param string|null $genre
     * @return array
     */
    public function findMovie(?string $title = null, ?string $genre = null): array
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('m.id as movie_id, m.title as movie_title, g.title as genre_title')
            ->from('movies', 'm')
            ->leftJoin('m', 'genres', 'g', 'g.id = m.genre_id');

        if ($title) {
            $queryBuilder->where('m.title like :title')
                ->setParameter(':title', '%' . $title. '%');
        }

        if ($genre) {
            $queryBuilder->andWhere('g.title like :genre')
                ->setParameter(':genre', '%' . $genre. '%');
        }

        return $queryBuilder->execute()->fetchAll(FetchMode::ASSOCIATIVE);
    }
}