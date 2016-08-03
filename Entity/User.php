<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * User
 *
 * @ORM\Table(name="User", indexes={@ORM\Index(name="Role", columns={"Role"})})
 * @ORM\Entity
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=64, nullable=false)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=88, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=false)
     */
    private $isactive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="UConexion", type="datetime", nullable=false)
     */
    private $uconexion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BenchmarkBundle\Entity\Rol
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Rol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Role", referencedColumnName="id")
     * })
     */
    private $role;

    private $isenabled;

    public function __construct()
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salt = md5(uniqid(null, true));
        $this->isenabled=1;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isactive
     *
     * @param boolean $isactive
     *
     * @return User
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return boolean
     */
    public function getIsactive()
    {
        return $this->isactive;
    }

    /**
     * Set uconexion
     *
     * @param \DateTime $uconexion
     *
     * @return User
     */
    public function setUconexion($uconexion)
    {
        $this->uconexion = $uconexion;

        return $this;
    }

    /**
     * Get uconexion
     *
     * @return \DateTime
     */
    public function getUconexion()
    {
        return $this->uconexion;
    }

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
     * Set role
     *
     * @param \BenchmarkBundle\Entity\Rol $role
     *
     * @return User
     */
    public function setRole(\BenchmarkBundle\Entity\Rol $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \BenchmarkBundle\Entity\Rol
     */
    public function getRoles()
    {

        return  array( $this->role->getRole());
    }
    public function getIsenabled(){
        return 1;
    }
    public function isEnabled(){
        return 1;//$this->isenabled;
    }
    public function setEnabled(){
        $this->isenabled=1;
    }
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }
     public function eraseCredentials()
    {
    }
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
    public function createPassword(){
        //\Symfony\Component\Security\Core\Encoder\
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($this->getPassword(), $this->getSalt());
        $this->setPassword($password);
    }
}
