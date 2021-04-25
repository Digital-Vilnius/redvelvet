<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryController extends AbstractCrudController
{
    private $translator;
    private $photoPath;

    public function __construct(string $photoPath, TranslatorInterface  $translator)
    {
        $this->photoPath = $photoPath;
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular($this->translator->trans('buttons.create_category'))
            ->setEntityLabelInPlural($this->translator->trans('titles.categories'))
            ->setSearchFields(['id', 'title', 'created', 'updated']);

    }

    public function configureFields(string $pageName): array
    {
        return [
            IntegerField::new('id', $this->translator->trans('labels.id'))->hideOnForm(),
            ImageField::new('fileName', $this->translator->trans('labels.photo'))->setBasePath($this->photoPath)->hideOnForm(),
            TextareaField::new('file', $this->translator->trans('labels.photo'))->setFormType(VichImageType::class)->onlyOnForms(),
            TextField::new('title', $this->translator->trans('labels.title')),
            AssociationField::new('parent', $this->translator->trans('labels.parent')),
            AssociationField::new('products', $this->translator->trans('labels.products'))->hideOnForm(),
            TextField::new('updated', $this->translator->trans('labels.updated'))->hideOnForm(),
            TextField::new('created', $this->translator->trans('labels.created'))->hideOnForm()
        ];
    }
}