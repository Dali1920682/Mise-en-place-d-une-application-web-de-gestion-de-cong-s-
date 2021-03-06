<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
      /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\conge", mappedBy="user")
     */
    private $conge;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

   

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->conge = new ArrayCollection();
        
    }
  


}
