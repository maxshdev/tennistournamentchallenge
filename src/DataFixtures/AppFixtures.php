<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Player;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $womans = [
            "Alicia Mateu",
            "Rocio Antunez", 
            "Fatiha Gabarri", 
            "Latifa Camacho", 
            "Paola Fajardo", 
            "Ana Valls", 
            "Maria Victoria Chaparro", 
            "Izaskun Arenas",
            "Otilia Pons",
            "Azucena Orozco",
            "Nahia Gascon",
            "Manuela Pulido",
            "Maria Pino Campillo",
            "Amaia Díaz",
            "Caridad del Olmo",
            "Maria Rosario Godoy"
        ];

        $mens = [
            "Francisco Borja",
            "Dario Palomo",
            "Luis Alberto Bautista",
            "Jose Francisco Moral",
            "Pablo Cuesta",
            "Hector Brito",
            "Izan Aroca",
            "Matias Yague",
            "Daniel Calle",
            "Didac Criado",
            "Rodolfo Carvajal",
            "Francisco Calero",
            "Alonso Soto",
            "Pedro Maria Aguilar",
            "Alonso Zambrano",
            "Ignacio Moreira"
        ];

        for ($i = 0; $i < 16; $i++) {
            
            $entity = new Player();
            $entity->setName( $womans[$i] );
            $entity->setHabilityLv( random_int(10, 100) );
            $entity->setSex('F');
            $entity->setReactionTime( random_int(10, 100) );

            $manager->persist($entity);

            $entity = new Player();
            $entity->setName( $mens[$i] );
            $entity->setHabilityLv( random_int(10, 100) );
            $entity->setSex('M');
            $entity->setStrength( random_int(10, 100) );
            $entity->setDisplacementVelocity( random_int(10, 100) );

            $manager->persist($entity);
        }

        $manager->flush();
    }

}
