<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Users
 *
 * @ORM\Entity
 * @ORM\Table(name="users", indexes={@ORM\Index(name="fk_Users_UserRanks1_idx", columns={"RankId"}), @ORM\Index(name="fk_Users_Images1_idx", columns={"ImageId"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class Users implements AdvancedUserInterface, \Serializable
{

    /**
     * @var integer
     *
     * @ORM\Column(name="UserId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="UserName", type="string", length=50, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=50, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Surname", type="string", length=50, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="PhoneNumber", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $phonenumber;

    /**
     * @var string
     *
     * @ORM\Column(name="IsActive", type="boolean", length=45, nullable=false)
     */
    private $isactive;

    /**
     * @var Userranks
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Userranks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RankId", referencedColumnName="RankId")
     * })
     */
    private $rankid;

    /**
     * @var Images
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Images")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ImageId", referencedColumnName="ImageId")
     * })
     */
    private $imageid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="RegistrationDate", type="datetime", nullable=false)
     */
    private $registrationdate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Pageroutes", inversedBy="userid")
     * @ORM\JoinTable(name="userroutes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="UserId", referencedColumnName="UserId")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="RouteId", referencedColumnName="RouteId")
     *   }
     * )
     */
    private $routeid;

    private $usergrantedroutes;

    public function __construct()
    {
        $this->isactive = true;
        $this->registrationdate = new \DateTime();
// may not be needed, see section on salt below
// $this->salt = md5(uniqid('', true));
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;

    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @return bool|string
     */
    public function isEnabled()
    {
        return $this->isactive;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->userid,
            $this->username,
            $this->password,
            $this->isactive,
// see section on salt below
// $this->salt,
        ));
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->userid,
            $this->username,
            $this->password,
            $this->isactive,
// see section on salt below
// $this->salt
            ) = unserialize($serialized);
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }


    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return int
     */
    public function getUserid(): int
    {
        return $this->userid;
    }


    /**
     * @param int $userid
     */
    public function setUserid(int $userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * @param string $phonenumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }

    /**
     * @return Userranks
     */
    public function getRankid()
    {
        return $this->rankid;
    }

    /**
     * @param Userranks $rankid
     */
    public function setRankid(Userranks $rankid)
    {
        $this->rankid = $rankid;
    }



    /**
     * Set isactive
     *
     * @param string $isactive
     *
     * @return Users
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return string
     */
    public function getIsactive()
    {
        return $this->isactive;
    }

    /**
     * Set registrationdate
     *
     * @param \DateTime $registrationdate
     *
     * @return Users
     */
    public function setRegistrationdate($registrationdate)
    {
        $this->registrationdate = $registrationdate;

        return $this;
    }

    /**
     * Get registrationdate
     *
     * @return \DateTime
     */
    public function getRegistrationdate()
    {
        return $this->registrationdate;
    }

    /**
     * @return Images
     */
    public function getImageid()
    {
        return $this->imageid;
    }

    /**
     * @param Images $imageid
     */
    public function setImageid(Images $imageid)
    {
        $this->imageid = $imageid;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRouteid()
    {
        return $this->routeid;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $routeid
     */
    public function setRouteid(Pageroutes $routeid)
    {
        $this->routeid[] = $routeid;
    }

    /**
     * @return mixed
     */
    public function getUsergrantedroutes()
    {
        return $this->usergrantedroutes;
    }

    /**
     * @param mixed $usergrantedroutes
     */
    public function setUsergrantedroutes($usergrantedroutes)
    {
        $this->usergrantedroutes = $usergrantedroutes;
    }


}
