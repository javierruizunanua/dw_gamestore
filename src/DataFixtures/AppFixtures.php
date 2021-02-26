<?php

namespace App\DataFixtures;

use App\Entity\Games;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $c = new Categories();
        //Creating 2 categories
        for($i = 0; $i < 2; $i++){
            $category = new Categories();
            
            $category->setName("category$i");
            $c = $category;
            $manager->persist($category);
        }
        
        // Creating 3 games
        for ($i = 0; $i < 3; $i++) {
            $game = new Games();
            
            $game->setName("nombre$i");
            $game->setPrice(20*$i);
            $game->setRating($i);
            $game->setYear(2010+$i);
            $game->setDescription("La descripción del juego$i");
            $game->setImage("https://s.cdnshm.com/catalog/es/t/588886651/ps4-official-dualshock-4-urban-camo-controller.jpg");
            $game->setCategoriesId($c);
            
            $manager->persist($game);
        }
        
        $manager->flush();
    }
}
