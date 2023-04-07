<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('livres'),
            AssociationField::new('user'),
            // DateTimeImmutable::new('dateReservation')
        ];
    }
}

// une asso vers livre et user
