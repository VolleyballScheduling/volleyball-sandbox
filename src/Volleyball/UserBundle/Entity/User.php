<?php
namespace Volleyball\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Entity\User as BaseUser;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

use Volleyball\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *         "faculty" = "Volleyball\FacilityBundle\Entity\Faculty", 
 *         "passel_leader" = "Volleyball\PasselBundle\Entity\Leader", 
 *         "attendee" = "Volleyball\PasselBundle\Entity\Attendee", 
 *         "admin" = "Admin"
 *     }
 * )
 * @UniqueEntity(
 *     fields = "username",
 *     targetClass = "Volleyball\UserBundle\Entity\User",
 *     message="fos_user.username.already_used"
 *)
 * @UniqueEntity(
 *     fields = "email",
 *     targetClass = "Volleyball\UserBundle\Entity\User",
 *     message="fos_user.email.already_used"
 *)
 *
 */
abstract class User extends BaseUser
{
    use TimestampableTrait;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Please enter your first name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min="3",
     *     minMessage="The name is too short.",
     *     groups={"Registration", "Profile"},
     *     max="255",
     *     maxMessage="The name is too long."
     *)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Please enter your last name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min="3",
     *     minMessage="The name is too short.",
     *     groups={"Registration", "Profile"},
     *     max="255",
     *     maxMessage="The name is too long."
     *)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = "1",
     *      max = "1",
     *      minMessage = "Must be at least {{ limit }} characters length",
     *      maxMessage = "Cannot be longer than {{ limit }} characters length"
     * )
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"M", "F"})
     */
    protected $gender;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\EnrollmentBundle\Entity\PasselEnrollment", inversedBy="user")
     * @ORM\JoinColumn(name="activeEnrollmentId", referencedColumnName="id", nullable=true)
     */
    protected $activeEnrollment;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="googleId", type="string", length=255, nullable=true)
     */
    protected $googleId;

    /**
     * @var string
     *
     * @ORM\Column(name="linkedinId", type="string", length=255, nullable=true)
     */
    protected $linkedinId;

    /**
     * @var string
     *
     * @ORM\Column(name="twitterId", type="string", length=255, nullable=true)
     */
    protected $twitterId;

    /**
     * @var string
     *
     * @ORM\Column(name="foursquareId", type="string", length=255, nullable=true)
     */
    protected $foursquareId;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    protected $avatar = '/bundles/Volleyballuser/img/avatars/default.png';

    /**
    * @Gedmo\Slug(fields={"lastName", "firstName"})
    * @ORM\Column(length=128, unique=true)
    */
    protected $slug;

    /**
     * Get slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     */
    public function setSlug($slug = null)
    {
        if (null == $slug) {
            $this->slug = str_replace(
                ' ',
                '-',
                $this->getName()
            );
        }

        return $this;
    }

    public function getName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastname();
    }

    /**
     * Set activeEnrollment
     *
     * @param  Volleyball\EnrollmentBundle\Entity\PasselEnrollment $activeEnrollment
     * @return User
     */
    public function setActiveEnrollment(ActiveEnrollment $activeEnrollment = null)
    {
        $this->activeEnrollment = $activeEnrollment;

        return $this;
    }

    /**
     * Get activeEnrollment
     *
     * @return Volleyball\EnrollmentBundle\Entity\PasselEnrollment
     */
    public function getActiveEnrollment()
    {
        return $this->activeEnrollment;
    }

    /**
     * @param  string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
        $this->salt = '';
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstName($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastName($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }

    /**
     * @param  string $firstName
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param  string $lastName
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set googleId
     *
     * @param  string $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set linkedinId
     *
     * @param  string $linkedinId
     * @return User
     */
    public function setLinkedinId($linkedinId)
    {
        $this->linkedinId = $linkedinId;

        return $this;
    }

    /**
     * Get linkedinId
     *
     * @return string
     */
    public function getLinkedinId()
    {
        return $this->linkedinId;
    }

    /**
     * Set twitterId
     *
     * @param  string $twitterId
     * @return User
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * Set foursquareId
     *
     * @param  string $foursquareId
     * @return User
     */
    public function setFoursquareId($foursquareId)
    {
        $this->foursquareId = $foursquareId;

        return $this;
    }

    /**
     * Get foursquareId
     *
     * @return string
     */
    public function getFoursquareId()
    {
        return $this->foursquareId;
    }

    /**
     * Set avatar
     *
     * @param  string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getUrl()
    {
        return $this->url;
    }
   
    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
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
}
