<?php

namespace App\Controller\Admin;

use App\Entity\GalleryPhoto;
use App\Utils\DateUtils;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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

    public function configureFields(string $pageName): array
    {
        return [
            IntegerField::new('id', 'labels.id')->hideOnForm(),

            ImageField::new('fileName', 'labels.photo')->setBasePath($this->photoPath)->hideOnForm(),

            TextField::new('file', 'labels.photo')
                ->setFormType(VichImageType::class)
                ->setFormTypeOption('allow_delete', false)
                ->onlyOnForms(),

            TextField::new('title', 'labels.title'),

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