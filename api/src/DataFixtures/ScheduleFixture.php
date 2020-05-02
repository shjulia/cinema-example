<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\Movie\Entity\Movie\Movie;
use App\Model\Movie\Entity\Schedule\Id;
use App\Model\Movie\Entity\Schedule\Schedule;
use App\Model\Movie\Entity\Schedule\Time;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ScheduleFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $movies = [];

        for ($week = 0; $week < 50; $week++) {
            $title = 'film' . $week;
            $movies[] = $this->getReference($title);
        }

        $startDate = new \DateTimeImmutable('+1day');

        for ($week = 0; $week < 15; $week++) {
            for ($day = 0; $day < 7; $day++) {
                $schedule = new Schedule(
                    Id::next(),
                    $week + 1,
                    $day + 1
                );
                for ($film = 0; $film < 4; $film++) {
                    $endDate = $startDate->modify('+2hours');

                    $schedule->addMovie(
                        $this->faker->randomElement($movies),
                        new Time(
                            $startDate,
                            $endDate
                        )
                    );

                    $startDate = $endDate;

                    $manager->persist($schedule);
                }
            }
        }
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            MovieFixture::class
        ];
    }
}