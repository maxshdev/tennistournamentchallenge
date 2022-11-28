<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Monolog\DateTimeImmutable;

use App\Entity\Player;
use App\Entity\Tournament;
use App\Entity\Division;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $tournament_f = new Tournament();
        $tournament_f->setEventDescription("ATP World Tour 250");
        $tournament_f->setStartDate( new DateTimeImmutable('2022-06-06') );
        $tournament_f->setYear( 2022 );
        $tournament_f->setCountry("ARG");
        $tournament_f->setSex('F');
        $tournament_f->setCategory( "Amateurs" );

        $manager->persist($tournament_f);

        $tournament_m = new Tournament();
        $tournament_m->setEventDescription("ATP Challenger Series");
        $tournament_m->setStartDate( new DateTimeImmutable('2022-03-11') );
        $tournament_m->setYear( 2022 );
        $tournament_m->setCountry("ARG");
        $tournament_m->setSex('M');
        $tournament_m->setCategory( "Professional" );

        $manager->persist($tournament_m);

        $phases = [
            'round of 16',
            'quarter finals',
            'semifinal',
            'final'
        ];

        $panels = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H'
        ];

        for ($x = 0; $x < 4; $x++) {

            for ($y = 0; $y < 8; $y++) {

                $division = new Division();
                $division->setTournament( $tournament_f );
                $division->setPhase( $phases[$x] );
                $division->setPanel( $panels[$y] );
        
                $manager->persist($division);

                $division = new Division();
                $division->setTournament( $tournament_m );
                $division->setPhase( $phases[$x] );
                $division->setPanel( $panels[$y] );
        
                $manager->persist($division);

                if ($x == 1 && $y == 4) break;
                if ($x == 2 && $y == 1) break;
                if ($x == 3 && $y == 0) break;
            }
        }


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

            if (($i % 2) == 0) {

            }
            
            $entity = new Player();
            $entity->setName( $womans[$i] );
            $entity->setHabilityLv( random_int(10, 100) );
            $entity->setSex('F');
            $entity->setReactionTime( random_int(10, 100) );
            $entity->addTournament( $tournament_f );

            $manager->persist($entity);

            $entity = new Player();
            $entity->setName( $mens[$i] );
            $entity->setHabilityLv( random_int(10, 100) );
            $entity->setSex('M');
            $entity->setStrength( random_int(10, 100) );
            $entity->setDisplacementVelocity( random_int(10, 100) );
            $entity->addTournament( $tournament_m );

            $manager->persist($entity);
        }

        $manager->flush();
    }

}
