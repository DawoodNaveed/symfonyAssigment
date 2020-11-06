<?php


namespace App\Controller\Admin;


use App\Entity\OrderBook;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OrderBookCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return OrderBook::class;
    }
    public function configureFields(string $pageName): iterable
    {


        $fields = [
            AssociationField::new('bookId'),
            AssociationField::new('userEmail'),
            BooleanField::new('processing'),
            TextField::new('phoneNumber'),
            TextField::new('Address')


        ];

        return $fields;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters

            ->add('processing')

            ;
    }

}