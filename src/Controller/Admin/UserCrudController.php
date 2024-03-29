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
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

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
            ->setPaginatorPageSize(15)
            ->setEntityPermission('ROLE_ADMIN')
            ->renderContentMaximized();
    }
   
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->setLabel('Id')
                ->hideOnForm(),
            TextField::new('getFullName')
                ->setLabel('Nom et Prénom')
                ->hideOnForm(),
            TextField::new('nomUtilisateur')
                ->setLabel('Nom')
                ->hideOnIndex(),
            TextField::new('prenomUtilisateur')
                ->setLabel('Prénom')
                ->hideOnIndex(),
            BooleanField::new('isVerified')
                ->setLabel('Compte vérifié'),
            TextField::new('email')
                ->setLabel('Email')
                ->setFormTypeOption('disabled','disable'),
            ArrayField::new('roles')
                ->setLabel('Roles'),
            DateField::new('createdAt')
                ->setLabel('Date création')
                ->setFormat('dd-MM-yyyy')
                ->setFormTypeOption('disabled','disable'),
            DateField::new('validatedAt')
                ->setLabel('Date validation')
                ->setFormat('dd-MM-yyyy'),
            DateField::new('updatedAt')
                ->setLabel('Date modification')
                ->setFormat('dd-MM-yyyy'),

        ];
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
        ;
    }
}
