<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Comptabilite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
        return Comptabilite::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural("Catégories")
        ->setEntityLabelInSingular("Catégorie")
        ->setPaginatorPageSize(15)
        ->setEntityPermission('ROLE_ADMIN')
        ->renderContentMaximized();
    }
    
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nomCategorie'),
            AssociationField::new('comptabilite'),
        ];
    }
    
}
