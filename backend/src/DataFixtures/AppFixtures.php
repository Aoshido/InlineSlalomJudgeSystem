<?php

namespace App\DataFixtures;

use App\Entity\Judge;
use App\Entity\Run;
use App\Entity\Skater;
use App\Entity\Trick;
use App\Entity\TrickClassification;
use App\Enum\TrickFamily;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // SKATER
        $skater = new Skater();
        $skater->setName("Test Skater");
        $manager->persist($skater);

        // RUN
        $run = new Run();
        $run->setSkater($skater);
        $run->setTournament($this->createTournament($manager));

        $manager->persist($run);

        // JUDGES
        $judge1 = new Judge();
        $judge1->setName("Judge 1");
        $judge1->setTournament($run->getTournament());
        $manager->persist($judge1);

        $judge2 = new Judge();
        $judge2->setName("Judge 2");
        $judge2->setTournament($run->getTournament());
        $manager->persist($judge2);

        // TRICKS
        $tricks = [
            ["Butterfly", TrickFamily::OTHERS],
            ["Xpecial", TrickFamily::OTHERS],
            ["Wiper", TrickFamily::JUMPING],
            ["Footgun", TrickFamily::SITTING],
        ];

        foreach ($tricks as [$name, $family]) {
            $trick = new Trick();
            $trick->setName($name);
            $manager->persist($trick);

            $classification = new TrickClassification();
            $classification->setTrick($trick);
            $classification->setYear(2026);
            $classification->setGrade("A");
            $classification->setLevel(random_int(1, 10));
            $classification->setFamily($family);

            $manager->persist($classification);
        }

        $manager->flush();
    }

    private function createTournament(ObjectManager $manager)
    {
        $tournament = new \App\Entity\Tournament();
        $tournament->setName("Test Tournament");
        $tournament->setKey("TEST01");

        $manager->persist($tournament);

        return $tournament;
    }
}
