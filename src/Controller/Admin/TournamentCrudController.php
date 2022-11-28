<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Tournament;
use App\Entity\Division;

class TournamentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tournament::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $executeProcess = Action::new('executeProcess', 'Load and Register Tournament Players', 'fa fa-file-invoice')->linkToCrudAction('loadTournamentPlayers');
        $simulateProcess = Action::new('simulateProcess', 'Simulate Tournament', 'fa fa-play')->linkToCrudAction('simulateTournamentPlayers');
        
        return $actions
            ->add(Crud::PAGE_INDEX, $executeProcess)
            ->add(Crud::PAGE_INDEX, $simulateProcess)
        ;
    }

    public function loadTournamentPlayers(AdminContext $context, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $tournament = $context->getEntity()->getInstance();
        
        // $players = $tournament->getPlayers()->getValues(); // not suffle randomize register players.
        $players = $this->custom_shuffle($tournament->getPlayers()->getValues()); // suffle randomize register players.
        
        $divisions = $em->getRepository(Division::class)->findBy(['tournament' => $tournament->getId(), 'phase' => 'round of 16']);

        foreach ($divisions as $division) {
            
            $division->addTuple($players[0]);
            $division->addTuple($players[1]);

            $em->persist($division);

            $players = array_slice($players, 2);
        }

        $em->flush();

        $response = new Response('success');
        
        return $response;
    }

    public function simulateTournamentPlayers(AdminContext $context, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $tournament = $context->getEntity()->getInstance();
        
        $divisions = $em->getRepository(Division::class)->findBy(['tournament' => $tournament->getId(), 'phase' => 'round of 16']);

        foreach ($divisions as $division) {
            
            $players_of_division = $division->getTuples()->getValues();

            // here goes the logic of calculate the winner, now is randomize beetween the two players of the division.
            $player_winner = $players_of_division[array_rand($players_of_division, 1)];

            $division->setWinner($player_winner);

            $em->persist($division);
        }

        $em->flush();

        $response = new Response('success');
        
        return $response;
    }

    function custom_shuffle($my_array = array()) {
        
        $copy = array();
        
        while (count($my_array)) {
          $element = array_rand($my_array);
          $copy[$element] = $my_array[$element];
          unset($my_array[$element]);
        }

        return $copy;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
