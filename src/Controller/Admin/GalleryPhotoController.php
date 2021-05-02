<?php

namespace App\Controller\Admin;

use App\Entity\GalleryPhoto;
use App\Utils\DateUtils;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Iterable_;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GalleryPhotoController extends AbstractCrudController
{
    private $photoPath;

    public function __construct(string $photoPath)
    {
        $this->photoPath = $photoPath;
    }

    public static function getEntityFqcn(): string
    {
        return GalleryPhoto::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setTimezone('Europe/Vilnius')
            ->setDateTimeFormat('yyyy-MM-dd HH:mm:ss')
            ->setEntityLabelInSingular('buttons.create_gallery_photo')
            ->setEntityLabelInPlural('titles.gallery')
            ->setFormOptions(['validation_groups' => ['add']], ['validation_groups' => []])
            ->setSearchFields(['id', 'title', 'created', 'updated']);
    }

    public function configureFields(string $pageName): Iterable
    {
        yield IdField::new('id', 'labels.id')
            ->hideOnForm();

        yield ImageField::new('fileName', 'labels.photo')
            ->setBasePath($this->photoPath)
            ->hideOnForm();

        yield TextField::new('file', 'labels.photo')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete', false)
            ->onlyOnForms();

        yield TextField::new('title', 'labels.title');

        yield DateTimeField::new('updated', 'labels.updated')
            ->hideOnForm()
            ->formatValue(function ($value) {
                return DateUtils::formatDateTime($value);
            });

        yield DateTimeField::new('created', 'labels.created')
            ->hideOnForm()
            ->formatValue(function ($value) {
                return DateUtils::formatDateTime($value);
            });
    }
}