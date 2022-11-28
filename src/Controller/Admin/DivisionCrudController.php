<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use App\Entity\Division;

class DivisionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Division::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName) {
            
            yield AssociationField::new('tournament', 'Tournament');
            yield TextField::new('phase', 'Phase');
            yield TextField::new('panel', 'Panel');
            yield AssociationField::new('winner', 'Winner');

        } else {

            yield FormField::addPanel('Details', 'fa fa-list');
    
            yield FormField::addRow();
    
            yield AssociationField::new('tournament', 'Tournament');
            yield ChoiceField::new('phase', 'Phase')
                ->setChoices(fn () => [
                    'round of 16' => 'round of 16', 
                    'quarter finals' => 'quarter finals',
                    'semifinal' => 'semifinal',
                    'final' => 'final'
                ]);
            yield ChoiceField::new('panel', 'Panel')
                ->setChoices(fn () => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                    'F' => 'F',
                    'G' => 'G',
                    'H' => 'H',
                ]);
            yield AssociationField::new('tuples', 'Tuples');
            yield AssociationField::new('winner', 'Winner');
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(16)
        ;
    }
}
