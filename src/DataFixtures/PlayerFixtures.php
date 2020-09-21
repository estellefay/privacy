<?php

namespace App\DataFixtures;


use App\Entity\Player;
use App\DataFixtures\UserFixtures;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class PlayerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // Create player
        for ($i = 0; $i < 10; $i++) {
            $player = new Player();
            $player->setName($faker->userName);
            $player->setPoint(0);
            $player->setStar(0);
            // this reference returns the User object created in UserFixtures
            $player->setUser($this->getReference(UserFixtures::USER_PLAYER_REFERENCE));
            $manager->persist($player);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}