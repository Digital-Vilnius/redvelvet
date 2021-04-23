<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @Assert\NotBlank(message="field_is_required")
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @Assert\NotBlank(message="field_is_required")
     * @ORM\Column(type="string")
     */
    private $measurement;

    /**
     * @Assert\NotBlank(message="field_is_required")
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @Assert\NotBlank(message="field_is_required")
     * @ORM\Column(type="string")
     */
    private $photoUrl;

    /**
     * @Assert\NotBlank(message="field_is_required")
     * @Assert\Regex(pattern="/^-?[0-9]+(?:\.[0-9]{0,2})?$/", message="field_is_invalid")
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @Assert\NotBlank(message="field_is_required")
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @Assert\NotBlank(message="field_is_required")
     * @ORM\Column(type="string")
     */
    private $created;

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new DateTime('now');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    public function setPhotoUrl($photoUrl): void
    {
        $this->photoUrl = $photoUrl;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category): void
    {
        $this->category = $category;
    }

    public function getMeasurement()
    {
        return $this->measurement;
    }

    public function setMeasurement($measurement): void
    {
        $this->measurement = $measurement;
    }

    public function getRootCategory()
    {
        $rootCategory = $this->category;
        while($rootCategory->getParent()) $rootCategory = $rootCategory->getParent();
        return $rootCategory;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getCreated()
    {
        return $this->created;
    }
}