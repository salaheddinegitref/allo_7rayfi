<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Annonce;
use Faker\Factory;
use Cocur\Slugify\Slugify;
use App\Entity\Image;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        
        //gestion des users
        
        $users = [];
        $genres = ['male', 'female'];
        
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            
            $genre = $faker->randomElement($genres);
            
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99). '.jpg';
            
            $picture .= ($genre == 'male' ? 'men/' : 'wemen/'). $pictureId;
            
            $hash = $this->encoder->encodePassword($user, 'password');
            
            $user->setFirstName($faker->firstName($genre))
                 ->setLastName($faker->lastName)
                 ->setAddress($faker->address)
                 ->setEmail($faker->email)
                 ->setAge(mt_rand(18, 60))
                 ->setIntroduction($faker->sentence)
                 ->setPhone($faker->phoneNumber)
                 ->setHash($hash)
                 ->setPicture("/images/plombier.jpg");
            
            $manager->persist($user);
            $users[] = $user;
        }
        
        //gestion des annonces
        for ($i = 1; $i <= 30; $i++) {
            $annonce = new Annonce();
            
            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            
            $user = $users[mt_rand(0, count($users) - 1)];
            
            $annonce->setTitle($title)
                    ->setPrice(mt_rand(50, 500))
                    ->setCoverImage("/images/plomberie.jpg")
                    ->setIntroduction($introduction)
                    ->setAuthor($user);
                    
            
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
