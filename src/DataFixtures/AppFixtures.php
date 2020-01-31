<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    /**
     * @var SluggerInterface
     */
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        
    }


    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // on crée les utilisateur
        $users = []; // le tableau va nous aidée a stocker les instances des user
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setUserName($faker->email);
            $manager->persist($user);
            $users[] = $user;
        }

        // on crée les produit
        for($i = 1; $i <= 100; $i++) {
            $product = new Product();
            $product->setName('iPhone ' .$i);
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setDescription('Un iPhone de '.rand(2000, 2020));
            $product->setPrice(rand(10, 1000) * 100); 
            $product->setUser($users[rand(0, 9)]);           
            $manager->persist($product);
        }
        

        $manager->flush();
    }
}
