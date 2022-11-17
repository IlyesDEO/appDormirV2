<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Lieux;
use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Lieux;
use App\Entity\Ville;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    /**
     * 
     * @var Generator
     */
    private Generator $faker;


    /**
     * Undocumented variable
     *
     * @var userPasswordHasherInterface
     */
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->faker = Factory::create('fr');
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {

            $amdinUser = new User();
            $amdinUser->setUsername('admin')
                 ->setRoles(['ADMIN'])
                 ->setPassword($this->userPasswordHasher->hashPassword($amdinUser, 'password'));
            $manager->persist($amdinUser);
        

        
        // $product = new Product();
        // $manager->persist($product);
        //Ville  
        $villes = [];
        $ville = new Ville();
        $ville->setNomVille("Lyon")
            ->setStatus(1);
        $manager->persist($ville);
        $villes[] = $ville;
        $manager->flush();

        $ville = new Ville();
        $ville->setNomVille("Paris")
            ->setStatus(1);
        $manager->persist($ville);
        $villes[] = $ville;
        $manager->flush();

        $ville = new Ville();
        $ville->setNomVille("Montpont")
            ->setStatus(1);
        $manager->persist($ville);
        $villes[] = $ville;
        $manager->flush();

        //Lieux
        $lieux = new Lieux();
        $lieux->setDescription("Foyer chaleureux")
            ->setAdresse("236 cours Lafayette")
            ->setStatus(1);
        $manager->persist($lieux);
        $manager->flush();
        
        
        $lieux = new lieux();
        $lieux->setDescription("Gare de part-dieu")
        ->setAdresse("5 Pl. Charles Béraudier, 69003 Lyon")
        ->setStatus(1)
        ->setIdVille($villes[0]);
        $manager->persist($lieux);
        $manager->flush();

        $lieux = new lieux();
        $lieux->setDescription("Confluence")
        ->setAdresse("112 Cr Charlemagne, 69002 Lyon ")
        ->setStatus(1)
        ->setIdVille($villes[0]);
        $manager->persist($lieux);
        $manager->flush();

        $lieux = new Lieux();
        $lieux->setDescription("Trop de monde")
            ->setAdresse("La defense")
            ->setStatus(1)
            ->setIdVille($villes[1]);
        $manager->persist($lieux);
        $manager->flush();


        $lieux = new lieux();
        $lieux->setDescription("Vertige")
        ->setAdresse("Tour Eiffel")
        ->setStatus(1)
        ->setIdVille($villes[1]);
        $manager->persist($lieux);
        $manager->flush();

        $lieux = new lieux();
        $lieux->setDescription("Ne pas être clostrophobe")
        ->setAdresse("Catacombe")
        ->setStatus(1)
        ->setIdVille($villes[1]);
        $manager->persist($lieux);
        $manager->flush();

        $lieux = new Lieux();
        $lieux->setDescription("Froid")
            ->setAdresse("Etang montpont")
            ->setStatus(1)
            ->setIdVille($villes[2]);
        $manager->persist($lieux);
        $manager->flush();




//Ville



        $lieux = new lieux();
        $lieux->setDescription("Sol pas confortable")
        ->setAdresse("Mairie")
        ->setStatus(1)
        ->setIdVille($villes[2]);
        $manager->persist($lieux);
        $manager->flush();

        $lieux = new lieux();
        $lieux->setDescription("Animaux sauvages")
        ->setAdresse("Foret blanche")
        ->setStatus(1)
        ->setIdVille($villes[2]);
        $manager->persist($lieux);
        $manager->flush();
    }
}
