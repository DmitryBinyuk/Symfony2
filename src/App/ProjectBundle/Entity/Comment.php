<?php

namespace App\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\ProjectBundle\Entity\Product;
use App\ProjectBundle\Entity\ProductComment;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\ProjectBundle\Entity\CommentRepository")
 */

class Comment
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
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=255)
     */
    private $body;

    /**
     * Many comments to one product
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="comments")
     * @ORM\JoinColumn(name="product_id")
     */
    private $product;

    /**
     * Many comments to one user
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id")
     */
    private $user;

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
     * @return Comment
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
     * Set body
     *
     * @param string $body
     *
     * @return Comment
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set product
     *
     * @param \App\ProjectBundle\Entity\Product $product
     *
     * @return Comment
     */
    public function setProduct(\App\ProjectBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \App\ProjectBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set user
     *
     * @param \App\ProjectBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\App\ProjectBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\ProjectBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
