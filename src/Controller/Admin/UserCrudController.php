<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('pseudo', 'Pseudo'),
            TextField::new('email', 'E-mail'),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prenom'),
            ArrayField::new('roles', 'Rôle'),
            TextField::new('ville')->hideOnIndex(),
            BooleanField::new('sexe')->hideOnIndex(),
            TextField::new('facebook')->hideOnIndex(),
            TextField::new('twitter')->hideOnIndex(),
            TextField::new('youtube')->hideOnIndex(),
            TextField::new('instagrame')->hideOnIndex(),
            BooleanField::new('personnel', 'Personnel'),
            BooleanField::new('isValide', 'Accepter utilisateur'),
        ];
    }
}