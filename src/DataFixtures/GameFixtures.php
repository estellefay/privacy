<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\DataFixtures\UserFixtures;;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class GameFixtures extends Fixture implements DependentFixtureInterface
{
    
    public const GAME_PLAYER_REFERENCE = 3;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $game = new Game();
            // this reference returns the User object created in UserFixtures
            $game->setUser($this->getReference(UserFixtures::USER_GAME_REFERENCE));
            $manager->persist($game);
        }
        $manager->flush();
        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::GAME_PLAYER_REFERENCE, $game);
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}