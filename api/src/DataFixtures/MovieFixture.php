<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\Movie\Entity\Movie\Id;
use App\Model\Movie\Entity\Movie\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $genres = [];
        foreach (GenreFixture::GENRES as $title) {
            $genres[] = $this->getReference($title);
        }

        for ($i = 0; $i < 50; $i++) {
            $title = 'film' . $i;
            $movie = new Movie(
                Id::next(),
                $title,
                $genres[rand(0, count($genres) - 1)]
            );

            $manager->persist($movie);
            $this->setReference($title, $movie);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            GenreFixture::class
        ];
    }
}