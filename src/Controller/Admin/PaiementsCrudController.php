<?php

namespace App\Controller\Admin;

use App\Entity\Paiements;
use App\Entity\Comptabilite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Polyfill\Intl\Idn\Idn;

class PaiementsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Paiements::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural("Paiements")
            ->setEntityLabelInSingular("Paiement")
            ->setPaginatorPageSize(15)
            ->setEntityPermission('ROLE_ADMIN')
            ->renderContentMaximized();
    }
        

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('moyenPaiement'),
        ];
    }
    
}
