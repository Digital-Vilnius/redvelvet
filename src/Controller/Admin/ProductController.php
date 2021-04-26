<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductPhotoType;
use App\Utils\DateUtils;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductController extends AbstractCrudController
{
    private $currency;
    private $photoPath;

    public function __construct(string $currency, string $photoPath)
    {
        $this->currency = $currency;
        $this->photoPath = $photoPath;
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setTimezone('Europe/Vilnius')
            ->setDateTimeFormat('yyyy-MM-dd HH:mm:ss')
            ->setEntityLabelInSingular('buttons.create_product')
            ->setEntityLabelInPlural('titles.products')
            ->setSearchFields(['id', 'title', 'price', 'measurement', 'category.title', 'created', 'updated']);
    }

    public function configureFields(string $pageName): array
    {
        return [
            IntegerField::new('id', 'labels.id')->hideOnForm(),
            ImageField::new('photos[0].fileName', 'labels.photo')->setBasePath($this->photoPath)->hideOnForm(),
            TextField::new('title', 'labels.title'),
            TextareaField::new('description', 'labels.description')->onlyOnForms(),
            MoneyField::new('price', 'labels.price')->setCurrency($this->currency)->setStoredAsCents(false),
            TextField::new('measurement', 'labels.measurement'),

            AssociationField::new('category', 'labels.category')
                ->setFormTypeOption('required', true),

            CollectionField::new('photos', 'labels.photos')
                ->onlyOnForms()
                ->setEntryType(ProductPhotoType::class),

            DateTimeField::new('updated', 'labels.updated')
                ->hideOnForm()
                ->formatValue(function ($value) {
                    return DateUtils::formatDateTime($value);
                }),

            DateTimeField::new('created', 'labels.created')
                ->hideOnForm()
                ->formatValue(function ($value) {
                    return DateUtils::formatDateTime($value);
                }),
        ];
    }
}