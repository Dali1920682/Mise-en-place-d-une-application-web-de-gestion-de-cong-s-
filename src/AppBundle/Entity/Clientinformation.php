<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Clientinformation
 *
 * @ORM\Table(name="clientinformation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientinformationRepository")
 */
class Clientinformation
{
  public function __construct() {
    $this->user = new ArrayCollection();
}
     /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy ="Clientinformation") 
     *@ORM\JoinColumn(name="user_id", referencedColumnName="id" )
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
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Typeprofession", inversedBy ="Clientinformation" ) 
     *@ORM\JoinColumn(name="Typeprofession_id", referencedColumnName="id")
     */
    private $Typeprofession ;
    
    //

    public function setTypeprofession($Typeprofession)
    {
      $this->Typeprofession = $Typeprofession;
      return $this;
    }
  
    public function getTypeprofession()
    {
      return $this->Typeprofession;
    }


    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\Typecontrat" , inversedBy ="Clientinformation") 
     *@ORM\JoinColumn(name="Typecontrat_id", referencedColumnName="id")
     */
    private $Typecontrat ;
    
    //

    public function setTypecontrat($Typecontrat)
    {
      $this->Typecontrat = $Typecontrat;
      return $this;
    }
  
    public function getTypecontrat()
    {
      return $this->Typecontrat;
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
     * @ORM\Column(name="dateoc", type="date")
     */
    private $dateoc;

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
     * Set dateoc
     *
     * @param \DateTime $dateoc
     *
     * @return Clientinformation
     */
    public function setDateoc($dateoc)
    {
        $this->dateoc = $dateoc;

        return $this;
    }

    /**
     * Get dateoc
     *
     * @return \DateTime
     */
    public function getDateoc()
    {
        return $this->dateoc;
    }
}

