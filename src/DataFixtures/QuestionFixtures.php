<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use App\Entity\Player;
use App\Entity\Game;

use App\DataFixtures\CategoryFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Faker;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // Create question
        for ($i = 0; $i < 20; $i++) {
            $question = new Question();
            $question->setName($faker->sentence);
            // this reference returns the User object created in UserFixtures
            $question->setCategory($this->getReference(CategoryFixtures::CATEGORY_QUESTION_REFERENCE));
            $manager->persist($question);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
        );
    }

}
