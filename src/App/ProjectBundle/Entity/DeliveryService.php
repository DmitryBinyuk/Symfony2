<?php

namespace App\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeliveryService
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\ProjectBundle\Entity\DeliveryServiceRepository")
 */
class DeliveryService
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
     * @var integer
     *
     * @ORM\Column(name="price_per_kilometer", type="integer")
     */
    private $pricePerKilometer;


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
     * @return DeliveryService
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
     * Set pricePerKilometer
     *
     * @param integer $pricePerKilometer
     *
     * @return DeliveryService
     */
    public function setPricePerKilometer($pricePerKilometer)
    {
        $this->pricePerKilometer = $pricePerKilometer;

        return $this;
    }

    /**
     * Get pricePerKilometer
     *
     * @return integer
     */
    public function getPricePerKilometer()
    {
        return $this->pricePerKilometer;
    }
}

