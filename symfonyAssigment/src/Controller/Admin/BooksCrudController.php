<?php

namespace App\Controller\Admin;

use App\Entity\Books;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use Vich\UploaderBundle\Form\Type\VichImageType;

class BooksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Books::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $imageFile = ImageField::new('imageFile')->setFormType(VichImageType::class);
        $image = ImageField::new('image')->setBasePath('/images/images');
        $date = TextField::new('publishedDate');
        $datefiled = DateField::new('publishedDate');

        $fields = [
            TextField::new('name'),
            TextField::new('author'),
            TextField::new('isbn'),


        ];
        if($pageName== Crud::PAGE_INDEX || $pageName==Crud::PAGE_DETAIL) {
            $fields[]=$image;
            $fields[]=$date;

        } else {
            $fields[] = $imageFile;
            $fields[]=$datefiled;
        }
        return $fields;
    }

}
