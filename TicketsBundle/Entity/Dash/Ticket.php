<?php

namespace Dashboard\TicketsBundle\Entity\Dash;

use Doctrine\ORM\Mapping as ORM;
use Dashboard\TicketsBundle\Entity\Dash\Category;
use Dashboard\TicketsBundle\Entity\Dash\status;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity
 */
class Ticket
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
     * @var integer
     *
     * @ORM\Column(name="author_id", type="integer")
     */
    private $authorId;

    /**
     * @var integer
     *
     * @ORM\Column(name="admin_id", type="integer")
     */
    private $adminId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     * 
     * @ORM\Column(name="category_id", type="integer")
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="status")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     * 
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     * 
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;


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
     * Set authorId
     *
     * @param integer $authorId
     * @return Ticket
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get authorId
     *
     * @return integer 
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Set adminId
     *
     * @param integer $adminId
     * @return Ticket
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;

        return $this;
    }

    /**
     * Get adminId
     *
     * @return integer 
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return Ticket
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Ticket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Ticket
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
     * Set content
     *
     * @param string $content
     * @return Ticket
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getCategorie()
    {
        
    }
}
