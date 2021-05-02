<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Utils\DateUtils;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryController extends AbstractCrudController
{
    private $photoPath;

    public function __construct(string $photoPath)
    {
        $this->photoPath = $photoPath;
    }

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setTimezone('Europe/Vilnius')
            ->setDateTimeFormat('yyyy-MM-dd HH:mm:ss')
            ->setEntityLabelInSingular('buttons.create_category')
            ->setEntityLabelInPlural('titles.categories')
            ->setFormOptions(['validation_groups' => ['add']], ['validation_groups' => []])
            ->setSearchFields(['id', 'title', 'created', 'updated']);

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_DETAIL, Action::DETAIL);
    }

    public function configureFields(string $pageName): array
    {
        return [
            IdField::new('id', 'labels.id')->hideOnForm(),
            ImageField::new('fileName', 'labels.photo')->setBasePath($this->photoPath)->hideOnForm(),

            TextField::new('file', 'labels.photo')
                ->setFormType(VichImageType::class)
                ->setFormTypeOption('allow_delete', false)
                ->onlyOnForms(),

            TextField::new('title', 'labels.title'),
            TextareaField::new('description', 'labels.description')->onlyOnForms(),
            AssociationField::new('parent', 'labels.parent'),
            AssociationField::new('products', 'labels.products')->hideOnForm(),

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