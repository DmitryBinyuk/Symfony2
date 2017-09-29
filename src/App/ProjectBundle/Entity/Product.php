<?php

namespace App\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Model\MediaInterface;
use App\ProjectBundle\Entity\DeliveryService;
use Doctrine\Common\Collections\ArrayCollection;
use App\ProjectBundle\Entity\Manager;
use App\ProjectBundle\Entity\Discount;
use App\ProjectBundle\Entity\ProductCategory;
use App\ProjectBundle\Entity\Comment;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\ProjectBundle\Entity\ProductRepository")
 */
class Product
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

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * 
     */
    protected $category;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="watches", type="integer")
     */
    private $watches = 0;

//    /**
//     * @ORM\ManyToMany(targetEntity="DeliveryService", mappedBy="products")
//     */
//    private $deliveryServices;

    /**
     * Many products to many managers
     * @ORM\ManyToMany(targetEntity="Manager", mappedBy="products")
     */
    private $managers;

    /**
     * Many products to one discount
     * @ORM\ManyToOne(targetEntity="Discount", inversedBy="products")
     * @ORM\JoinColumn(name="discount_id", referencedColumnName="id")
     */
    private $discount;

    /**
     * One product can have many comments
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="product")
     */
    private $comments;

    public function __construct() {
//        $this->deliveryServices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managers = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function addCategory(ProductCategory $category)
    {
        $this->category[] = $category;

        return $this;
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
     * @return Product
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
     * @return Product
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
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

  /**
     * Set category
     *
     * @param string $category
     *
     * @return Product
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
    
   /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     */
    protected $media;

    /**
     * @param MediaInterface $media
     */
    public function setMedia(MediaInterface $media)
    {
        $this->media = $media;
    }

    /**
     * @return MediaInterface
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Add delivery service
     *
     * @param DeliveryService $deliveryService
     */
    public function addDeliveryService(DeliveryService $deliveryService)
    {
        $this->deliveryServices[] = $deliveryService;

        return $this;
    }

    /**
     * Remove delivery service
     *
     * @param DeliveryService $deliveryService
     */
    public function removeDeliveryService(DeliveryService $deliveryService)
    {
        $this->deliveryServices->removeElement($deliveryService);
    }

    /**
     * Set watches
     *
     * @param integer $watches
     *
     * @return Product
     */
    public function setWatches($watches)
    {
        $this->watches = $watches;

        return $this;
    }

    /**
     * Get watches
     *
     * @return integer
     */
    public function getWatches()
    {
        return $this->watches;
    }

    /**
     * Get deliveryServices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeliveryServices()
    {
        return $this->deliveryServices;
    }

    /**
     * Add manager
     *
     * @param \App\ProjectBundle\Entity\Manager $manager
     *
     * @return Product
     */
    public function addManager(\App\ProjectBundle\Entity\Manager $manager)
    {
        $this->managers[] = $manager;

        return $this;
    }

    /**
     * Remove manager
     *
     * @param \App\ProjectBundle\Entity\Manager $manager
     */
    public function removeManager(\App\ProjectBundle\Entity\Manager $manager)
    {
        $this->managers->removeElement($manager);
    }

    /**
     * Get managers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * Set discount
     *
     * @param \App\ProjectBundle\Entity\Discount $discount
     *
     * @return Product
     */
    public function setDiscount(\App\ProjectBundle\Entity\Discount $discount = null)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return \App\ProjectBundle\Entity\Discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Add comment
     *
     * @param \App\ProjectBundle\Entity\Comment $comment
     *
     * @return Product
     */
    public function addComment(\App\ProjectBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \App\ProjectBundle\Entity\Comment $comment
     */
    public function removeComment(\App\ProjectBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
