<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\Movie\Entity\Genre\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixture  extends Fixture
{
    const GENRES = [
            'comedy',
            'detective',
            'sci-fi',
            'thriller'
        ];
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::GENRES as $title) {
            $genre = new Genre($title);
            $manager->persist($genre);
            $this->setReference($title, $genre);
        }

        $manager->flush();
    }
}