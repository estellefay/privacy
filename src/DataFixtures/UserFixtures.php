<?php

namespace App\DataFixtures;

use App\Entity\User;

use Faker;
use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    public const USER_PLAYER_REFERENCE = 0;
    public const USER_GAME_REFERENCE = 2;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // Create user
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->firstName);
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_ADMIN']);   
            $password = $this->encoder->encodePassword($user, 'pass_1234');
            $user->setPassword($password);
            $manager->persist($user);
        }
        $manager->flush();
        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::USER_PLAYER_REFERENCE, $user);
        $this->addReference(self::USER_GAME_REFERENCE, $user);

    }
}