<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * conge
 *
 * @ORM\Table(name="conge")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\congeRepository")
 */
class conge
{
    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="conge") 
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
     * @ORM\Column(name="datedepart", type="date")
     */
    private $datedepart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateretour", type="date")
     */
    private $dateretour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDemande", type="date")
     */
    private $dateDemande;

    

    /**
     * @var string
     *
     * @ORM\Column(name="nbjour", type="string", length=100)
     */
    private $nbjour;

    
    /**
     * @var string
     *
     * @ORM\Column(name="typec", type="string", length=255)
     */
    private $typec;

    /**
     * @var string
     *
     * @ORM\Column(name="decision", type="string", length=255)
     */
    private $decision;

    


   


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
     * Set datedepart
     *
     * @param \DateTime $datedepart
     *
     * @return congedb
     */
    public function setDatedepart($datedepart)
    {
        $this->datedepart = $datedepart;

        return $this;
    }

    /**
     * Get datedepart
     *
     * @return \DateTime
     */
    public function getDatedepart()
    {
        return $this->datedepart;
    }

    /**
     * Set dateretour
     *
     * @param \DateTime $dateretour
     *
     * @return congedb
     */
    public function setDateretour($dateretour)
    {
        $this->dateretour = $dateretour;

        return $this;
    }

    /**
     * Get dateretour
     *
     * @return \DateTime
     */
    public function getDateretour()
    {
        return $this->dateretour;
    }

    /**
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     *
     * @return congedb
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

   

    /**
     * Set nbjour
     *
     * @param string $nbjour
     *
     * @return congedb
     */
    public function setNbjour($nbjour)
    {
        $this->nbjour = $nbjour;

        return $this;
    }

    /**
     * Get nbjour
     *
     * @return string
     */
    public function getNbjour()
    {
        return $this->nbjour;
    }

    /**
     * Set typec
     *
     * @param string $typec
     *
     * @return conge
     */
    public function setTypec($typec)
    {
        $this->typec = $typec;

        return $this;
    }

    /**
     * Get typec
     *
     * @return string
     */
    public function getTypec()
    {
        return $this->typec;
    }

    /**
     * Set decision
     *
     * @param string $decision
     *
     * @return conge
     */
    public function setDecision($decision)
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * Get decision
     *
     * @return string
     */
    public function getDecision()
    {
        return $this->decision;
    }

    
    
}

