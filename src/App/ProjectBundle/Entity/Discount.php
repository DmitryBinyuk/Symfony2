<?php

namespace App\ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\ProjectBundle\Entity\Product;

/**
 * Discount
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\ProjectBundle\Entity\DiscountRepository")
 */
class Discount
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_count", type="integer")
     */
    private $totalCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_price", type="integer")
     */
    private $totalPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="discount_size_percent", type="integer")
     */
    private $discountSizePercent;

    /**
     * One discount to many products
     * @ORM\OneToMany(targetEntity="Product", mappedBy="discount")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Discount
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set totalCount
     *
     * @param integer $totalCount
     *
     * @return Discount
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    /**
     * Get totalCount
     *
     * @return integer
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     *
     * @return Discount
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return integer
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set discountSizePercent
     *
     * @param integer $discountSizePercent
     *
     * @return Discount
     */
    public function setDiscountSizePercent($discountSizePercent)
    {
        $this->discountSizePercent = $discountSizePercent;

        return $this;
    }

    /**
     * Get discountSizePercent
     *
     * @return integer
     */
    public function getDiscountSizePercent()
    {
        return $this->discountSizePercent;
    }

    /**
     * Add product
     *
     * @param \App\ProjectBundle\Entity\Product $product
     *
     * @return Discount
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
}
