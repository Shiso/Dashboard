<?php

namespace Dashboard\TicketsBundle\Entity\Dash;

use Doctrine\ORM\Mapping as ORM;

use Dashboard\TicketsBundle\Entity\Dash\Ticket;

/**
 * Reponse
 *
 * @ORM\Table(name="ticket_reponse")
 * @ORM\Entity
 */
class Reponse
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
     * @ORM\ManyToOne(targetEntity="Ticket")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     * 
     * @ORM\Column(name="idTicket", type="integer")
     */
    private $idTicket;

    /**
     * @var integer
     *
     * @ORM\Column(name="author_id", type="integer")
     */
    private $authorId;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Get idTicket
     *
     * @return integer 
     */
    public function getIdTicket()
    {
        return $this->idTicket;
    }

    /**
     * Get idTicket
     *
     * @return integer 
     */
    public function setIdTicket($idTicket)
    {
    	$this->idTicket = $idTicket;

        return $this;
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

    /**
     * Set date
     *
     * @param string $date
     * @return Ticket
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->date = new \DateTime();

        return $this;
    }
    /**
     * Get Reponse
     *
     * @return string $id 
     */
    public function __toString()
    {
        return $this->id . '';
    }

}
?>