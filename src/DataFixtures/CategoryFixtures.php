<?php

namespace App\DataFixtures;

use App\Entity\Category;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Faker;

use App\DataFixtures\QuestionFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_QUESTION_REFERENCE = 1;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // create 20 Catecory
        for ($i = 0; $i < 20; $i++) {
            $category = new Category();
            $category->setName($faker->word);

            $manager->persist($category);
        }
        $manager->flush();
        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::CATEGORY_QUESTION_REFERENCE, $category);

    }
}
