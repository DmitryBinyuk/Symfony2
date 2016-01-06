<?php

namespace App\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductCategory
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\ProjectBundle\Entity\ProductCategoryRepository")
 */
class ProductCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    
    // ...

    /**
     * @ORM\OneToMany(targetEntity="App\ProjectBundle\Entity\Product", mappedBy="category")
     */
    protected $products;
    
   /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="App\ProjectBundle\Entity\Producer", inversedBy="categories")
     * @ORM\JoinTable(name="categories_producers",
     *   joinColumns={
     *     @ORM\JoinColumn(name="productcategory_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="producer_id", referencedColumnName="id")
     *   }
     * )
     */
    private $producers;

    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->producers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProductCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProductCategory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add product
     *
     * @param \App\ProjectBundle\Entity\Product $product
     *
     * @return ProductCategory
     */
    public function addProduct(\App\ProjectBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \App\ProjectBundle\Entity\Product $product
     */
    public function removeProduct(\App\ProjectBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
    
    public function __toString()
    {
    return $this->getName();
    }

    /**
     * Add producer
     *
     * @param \App\ProjectBundle\Entity\Producer $producer
     *
     * @return ProductCategory
     */
    public function addProducer(\App\ProjectBundle\Entity\Producer $producers)
    {
        $this->producers[] = $producers;

        return $this;
    }

    /**
     * Remove producer
     *
     * @param \App\ProjectBundle\Entity\Producer $producer
     */
    public function removeProducer(\App\ProjectBundle\Entity\Producer $producers)
    {
        $this->producers->removeElement($producers);
    }

    /**
     * Get producers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducers()
    {
        return $this->producers;
    }
}
