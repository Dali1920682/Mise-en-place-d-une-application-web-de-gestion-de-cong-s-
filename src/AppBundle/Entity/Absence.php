<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table(name="absence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbsenceRepository")
 */
class Absence
{

    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="Absence") 
     *@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user ;
    
    //
    public function setUser($user)
    {
      $this->user = $user;
      return $this;
    }
  
    public function getUser()
    {
      return $this->user;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_absence", type="string", length=255)
     */
    private $etatAbsence;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Absence
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etatAbsence
     *
     * @param string $etatAbsence
     *
     * @return Absence
     */
    public function setEtatAbsence($etatAbsence)
    {
        $this->etatAbsence = $etatAbsence;

        return $this;
    }

    /**
     * Get etatAbsence
     *
     * @return string
     */
    public function getEtatAbsence()
    {
        return $this->etatAbsence;
    }
}

