<?php

namespace App\DataFixtures;

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

        //Lieux
        $lieux = new Lieux();
        $lieux->setDescription("Foyer chaleureux")
            ->setNote(8)
            ->setAdresse("236 cours Lafayette")
            ->setStatus(1);
        $manager->persist($lieux);
        $manager->flush();


        $lieux = new lieux();
        $lieux->setDescription("Gare de part-dieu")
        ->setNote(8)
        ->setAdresse("5 Pl. Charles Béraudier, 69003 Lyon")
        ->setStatus(1);
    $manager->persist($lieux);
    $manager->flush();

    $lieux = new lieux();
    $lieux->setDescription("Confluence")
    ->setNote(8)
    ->setAdresse("112 Cr Charlemagne, 69002 Lyon ")
    ->setStatus(1);
$manager->persist($lieux);
$manager->flush();



//Ville

        $lieux = new Lieux();
        $lieux->setDescription("Confluence")
            ->setNote(8)
            ->setAdresse("112 Cr Charlemagne, 69002 Lyon ")
            ->setStatus(1)
            ->setIdVille($villes[0]);
        $manager->persist($lieux);
        $manager->flush();
    }
}
