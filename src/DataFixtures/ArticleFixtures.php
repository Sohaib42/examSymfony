<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i = 1;$i<=10;$i++){
        $article = new Article();
            $article->setAuthor($faker->name());
            $article->setTitle($faker->sentence());
            $article->setDescription($faker->paragraph(mt_rand(5,15)));
            $article->setPhoto('/assets/image/placeholdit.png');
            $manager->persist($article);
            $manager->flush();
        }
    }
}
