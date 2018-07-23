<?php
// src/AppBundle/Entity/User.php

namespace User\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_fos")
 */
class User_Fos extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;





    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=30)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="signupdate", type="date", options={"default": "2000-01-01"})
     */
    private $signupdate;

    /**
     * @var text
     *
     * @ORM\Column(name="profile_photo", type="text", nullable=true)
     */
    private $profilePhoto;

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
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set signupdate
     *
     * @param \DateTime $signupdate
     *
     * @return User
     */
    public function setSignupdate($signupdate)
    {
        $this->signupdate = $signupdate;

        return $this;
    }

    /**
     * Get signupdate
     *
     * @return \DateTime
     */
    public function getSignupdate()
    {
        return $this->signupdate;
    }

    /**
     * Set profilePhoto
     *
     * @param \DateTime $signupdate
     *
     * @return User
     */
    public function setProfilePhoto($profilePhoto)
    {
        $this->profilePhoto = $profilePhoto;

        return $this;
    }

    /**
     * Get profilePhoto
     *
     * @return \DateTime
     */
    public function getProfilePhoto()
    {
        return $this->profilePhoto;
    }


    public function __construct()
    {
        parent::__construct();
        // your own logic
        $time = date('Y-m-d');
        $this->signupdate = new \DateTime($time);
    }

}