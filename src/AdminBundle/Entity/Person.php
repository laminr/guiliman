<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\PersonRepository")
 */
class Person
{
    const CLASS_NAME = "AdminBundle:Person";

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=20)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=30)
     */
    private $lastname;

    /**
     * @var int
     *
     * @ORM\Column(name="share", type="integer")
     */
    private $share;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Poll", mappedBy="person")
     */
    private $polls;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="person")
     * @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
     */
    private $user;

    function __toString()
    {
        return "$this->firstname $this->lastname";
    }


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
     * Set fistname
     *
     * @param string $firstname
     *
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get fistname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Person
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
     * Set share
     *
     * @param integer $share
     *
     * @return Person
     */
    public function setShare($share)
    {
        $this->share = $share;

        return $this;
    }

    /**
     * Get share
     *
     * @return int
     */
    public function getShare()
    {
        return $this->share;
    }

    /**
     * @return array
     */
    public function getPolls(): array
    {
        return $this->polls;
    }

    /**
     * @param array $polls
     */
    public function setPolls(array $polls)
    {
        $this->polls = $polls;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function setUserNull() {
        $this->user = null;
    }
}

