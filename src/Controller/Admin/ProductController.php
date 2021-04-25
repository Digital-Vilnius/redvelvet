<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductController extends AbstractCrudController
{
    private $currency;
    private $photoPath;
    private $translator;

    public function __construct(string $currency, string $photoPath, TranslatorInterface  $translator)
    {
        $this->currency = $currency;
        $this->photoPath = $photoPath;
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular($this->translator->trans('buttons.create_product'))
            ->setEntityLabelInPlural($this->translator->trans('titles.products'))
            ->setSearchFields(['id', 'title', 'price', 'measurement', 'category.title', 'created', 'updated']);
    }

    public function configureFields(string $pageName): array
    {
        return [
            IntegerField::new('id', $this->translator->trans('labels.id'))->hideOnForm(),
            ImageField::new('photos[0].fileName', $this->translator->trans('labels.photo'))->setBasePath($this->photoPath)->hideOnForm(),
            TextField::new('title', $this->translator->trans('labels.title')),
            MoneyField::new('price', $this->translator->trans('labels.price'))->setCurrency($this->currency)->setNumDecimals(2),
            TextField::new('measurement', $this->translator->trans('labels.measurement')),
            AssociationField::new('category', $this->translator->trans('labels.category')),
            TextField::new('updated', $this->translator->trans('labels.updated'))->hideOnForm(),
            TextField::new('created', $this->translator->trans('labels.created'))->hideOnForm()
        ];
    }
}