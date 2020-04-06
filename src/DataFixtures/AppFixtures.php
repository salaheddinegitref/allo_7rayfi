<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Annonce;
use Faker\Factory;
use Cocur\Slugify\Slugify;
use App\Entity\Image;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        
        for ($i = 1; $i <= 30; $i++) {
            
            $annonce = new Annonce();
            
            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            
            $annonce->setTitle($title)
                    ->setPrice(mt_rand(50, 500))
                    ->setCoverImage("/images/plomberie.jpg")
                    ->setIntroduction($introduction);
            
            for ($j = 1; $j <= mt_rand(1, 4); $j++) {
                $image = new Image();
                
                $image->setUrl("/images/plomberie2.jpg")
                      ->setCaption($faker->sentence)
                      ->setAnnonce($annonce);
                
                $manager->persist($image);
            }
            
            $manager->persist($annonce);                  
        }

        $manager->flush();
    }
}
