<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Faker\Factory;
use App\Entity\Event;
use App\Entity\Speaker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // Initialisation de Faker

        // Création d'un utilisateur admin
        $user = new User();
        $user->setEmail('admin@admin.fr')
            ->setPassword('$2y$13$NJpGg/WaTYG0ONkZkf6tvuPVmkuexwRQqozQKsp5b8yc9z9B3ziMG') // admin
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($user);


        for ($i = 0; $i < 200; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword('$2y$13$NJpGg/WaTYG0ONkZkf6tvuPVmkuexwRQqozQKsp5b8yc9z9B3ziMG');
            $user->setRoles(['ROLE_USER']);
            $user->setNickname($faker->name());


            // Permet de créer une référence pour pouvoir l'utiliser dans la loop posts
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        // Création de 40 speakers
        $speakerImages = [
            'user1.jpg',
            'user2.jpg',
            'user3.jpg',
            'user4.jpg',
        ];

        $speakerArray = [];
        for ($i = 1; $i < 41; $i++) {
            $speaker = new Speaker();
            $speaker->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setJob($faker->jobTitle)
                ->setCompany($faker->company)
                ->setExperience($faker->numberBetween(1, 20))
                ->setImage($faker->randomElement($speakerImages))
            ;
            array_push($speakerArray, $speaker);
            $manager->persist($speaker);
        }

        // Tableau de 20 événements
        $events = [
            'Frontend Masters',
            'Backend Masters',
            'Truth about PHP',
            'Symfony 7, what\'s new ?',
            'React, framework or library ?',
            'Vue.js, the new challenger ?',
            'Angular, the old one ?',
            'Web components, the future ?',
            'WebAssembly, how to use it ?',
            'GPDR, how to be compliant ?',
            'Docker, the new way to deploy ?',
            'Kubernetes, scale like a boss ?',
            'AWS, the cloud leader ?',
            'Wordpress, still alive ?',
            'PHP 8.3, what\'s new ?',
            'UI/UX, for frontend developers',
            'API, the essential for frontend',
            'GraphQL vs REST, which is better ?',
            'Web security, how to protect ?',
            'Web performance, how to optimize ?',
        ];

        // Boucle pour créer 20 événements
        for ($i = 0; $i < count($events); $i++) {
            $event = new Event();
            $event->setName($events[$i])
                ->setTheme('Web development')
                ->setDate($faker->dateTimeBetween('-6 months', '+6 months'))
                ->setLocation($faker->city)
                ->setAttendee($faker->numberBetween(10, 100))
                ->setPrice($faker->numberBetween(0, 250))
                ->addSpeaker($speakerArray[$i])
            ;
            $manager->persist($event);
        }




        // //  Création des utilisateurs
        $userArray = [];
        for ($i = 0; $i < 200; $i++) {
            $userArray[] = $this->getReference('user_' . $i, User::class);
        }

        //  Création d'un loop qui permet de créer au moin 200 posts
        for ($i = 0; $i < 200; $i++) {
            $post = new Post();
            $post->setTitle($faker->jobTitle());
            $post->setContent($faker->text());
            $post->setImage(('https://picsum.photos/800/420?random=' . $i));
            $post->setIsPublished($faker->boolean());
            $post->setUser($faker->randomElement($userArray));

            $manager->persist($post);
        }


        $manager->flush();
    }
}