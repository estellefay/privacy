<?php

namespace App\DataFixtures;

use App\Entity\Question;

use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // Create question
        for ($i = 0; $i < 20; $i++) {
            $question = new Question();
            $question->setName($faker->sentence);
            $manager->persist($question);
            $manager->flush();
        }
    }

}