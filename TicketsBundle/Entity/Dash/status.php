<?php

namespace Dashboard\TicketsBundle\Entity\Dash;

use Doctrine\ORM\Mapping as ORM;

/**
 * status
 *
 * @ORM\Table(name="status")
 * @ORM\Entity
 */
class status
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
     * @ORM\Column(name="status_name", type="string", length=40)
     */
    private $statusName;


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
     * Set statusName
     *
     * @param string $statusName
     * @return status
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;

        return $this;
    }

    /**
     * Get statusName
     *
     * @return string 
     */
    public function getStatusName()
    {
        return $this->statusName;
    }
}
