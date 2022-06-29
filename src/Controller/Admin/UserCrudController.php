<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\Cast\Bool_;

class UserCrudController extends AbstractCrudController
{
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural("Utilisateurs")
            ->setEntityLabelInSingular("Utilisateur")
            ->setPaginatorPageSize(15);
    }
   
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->setLabel('Id'),
            TextField::new('nomUtilisateur')
                ->setLabel('Nom'),
            TextField::new('prenomUtilisateur')
                ->setLabel('Prénom'),
            BooleanField::new('isVerified')
                ->setLabel('Compte vérifié'),
            TextField::new('email')
                ->setLabel('Email'),
            ArrayField::new('roles')
                ->setLabel('Roles'),
            DateField::new('createdAt')
                ->setLabel('Date création')
                ->setFormat('dd-mm-yyyy'),
            DateField::new('validatedAt')
                ->setLabel('Date validation')
                ->setFormat('dd-mm-yyyy'),
            DateField::new('updatedAt')
                ->setLabel('Date modification')
                ->setFormat('dd-mm-yyyy'),

        ];
    }
    
    
}
