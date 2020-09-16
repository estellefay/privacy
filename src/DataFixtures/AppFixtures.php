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

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // // Create user
        // for ($i = 0; $i < 50; $i++) {
        //     $user = new User();
        //     $user->setName($faker->firstName);
        //     $user->setEmail($faker->email);
        //     $user->setRoles(['ROLE_ADMIN']);   
        //     $password = $this->encoder->encodePassword($user, 'pass_1234');
        //     $user->setPassword($password);
        //     $manager->persist($user);
        // }
        // $manager->flush();

        // // create 20 Catecory
        // for ($i = 0; $i < 20; $i++) {
        //     $category = new Category();
        //     $category->setName($faker->word);
        //     $manager->persist($category);
        // }
        // $manager->flush();

        // Create player
        // for ($i = 0; $i < 50; $i++) {
        //     $player = new Player();
        //     $player->setName($faker->userName);
        //     $player->setPoint(0);
        //     $player->setStar(0);
        //     $manager->persist($player);

        // }
        // $manager->flush();


        // Create games
        $game = new Game();
        $manager->persist($game);
        $manager->flush();

    }
}
