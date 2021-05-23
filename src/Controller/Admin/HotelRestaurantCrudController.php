<?php

namespace App\Controller\Admin;

use App\Entity\HotelRestaurant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class HotelRestaurantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HotelRestaurant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $imageFile = TextField::new('imageFile')->setFormType(VichImageType::class);
        $image = ImageField::new('imageName', 'Image')->setBasePath('/images/hotel_restaurant');
        $fields = [
            TextField::new('titre'),
            TextEditorField::new('description')->hideOnIndex(),
            AssociationField::new('user', 'Ajouter par')->hideOnIndex()->hideOnForm(),
            DateField::new('publishedAt', 'Créer le ')->hideOnForm(),

        ];


        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }
        return $fields;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Hotels et restaurants')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modification')
            ->setDefaultSort(['publishedAt' => 'DESC']);
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('titre');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fas fa-plus ')->addCssClass("btn btn-success")->setLabel('Ajouter');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->addCssClass("btn btn-warning")->setLabel('Modifier');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')->addCssClass("btn btn-info")->setLabel('Voir');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash')->addCssClass("btn btn-outline-danger")->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->addCssClass("btn btn-warning")->setLabel('Modifier');
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash')->addCssClass("btn btn-outline-danger")->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action->setIcon('fas fa-arrow-left')->addCssClass("btn btn-info")->setLabel('Retour');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setIcon('fa fa-edit')->addCssClass("btn btn-success")->setLabel('Enregistrer et continuer');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('')->addCssClass("btn btn-info")->setLabel('Enregistrer');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setIcon('')->addCssClass("")->setLabel('Créer Ajouter');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('')->addCssClass("btn btn-info")->setLabel('Créer');
            });
    }
}
