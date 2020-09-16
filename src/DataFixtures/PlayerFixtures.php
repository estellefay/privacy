<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use App\Entity\Player;
use App\Entity\Game;

use Faker;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PlayerFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // Create player
        for ($i = 0; $i < 50; $i++) {
            $player = new Player();
            $player->setName($faker->userName);
            $player->setPoint(0);
            $player->setStar(0);
            $manager->persist($player);
        }
        $manager->flush();


    }
}
