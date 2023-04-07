<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use DateTime;
use Doctrine\DBAL\Types\DateImmutableType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Date;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }


    // public function configureFields(string $pageName): iterable
    // {
    //     return [

    //         TextField::new('titre'),
    //         TextField::new('auteur'),
    //         TextField::new('editeur'),
    //         TextField::new('genre'),
    //         BooleanField::new('isDisponible', false),
    //         DateField::new('date_publication'),
    //         AssociationField::new('')
    //     ];
    // }
}
