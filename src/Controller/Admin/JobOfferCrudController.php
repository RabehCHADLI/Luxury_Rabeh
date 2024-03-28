<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            AssociationField::new('category'),
            TextEditorField::new('description'),
            TextField::new('reference'),
            BooleanField::new('active'),
            TextField::new('notes'),
            TextField::new('job_title'),
            TextField::new('location'),
            IdField::new('salary'),
            DateField::new('CreatedAt'),
            DateField::new('closing_date'),
            AssociationField::new('jobType')


        ];
    }
}
