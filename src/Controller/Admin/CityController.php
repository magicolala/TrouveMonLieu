<?php

namespace App\Controller\Admin;

use App\Entity\City;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CityController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return City::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextField::new('country', 'Pays')
                ->formatValue(function ($value, $entity) {
                    return sprintf('<img src="https://flagcdn.com/16x12/%s.png" alt="%s">', strtolower($value), $value);
                })
                ->renderAsHtml(),
            // Ajoutez d'autres champs si nécessaire
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Villes')
            ->setEntityLabelInSingular('Ville');
    }
}
