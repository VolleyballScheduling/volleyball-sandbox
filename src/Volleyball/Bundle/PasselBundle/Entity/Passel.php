<?php
namespace Volleyball\Bundle\PasselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Volleyball\Bundle\PasselBundle\Entity\Faction;
use Volleyball\Bundle\PasselBundle\Entity\Leader;
use Volleyball\Bundle\OrganizationBundle\Entity\Council;
use Volleyball\Bundle\OrganizationBundle\Entity\Region;
use Volleyball\Bundle\EnrollmentBundle\Entity\Passel as PasselEnrollment;
use Volleyball\Bundle\PasselBundle\Entity\Type;
use Volleyball\Bundle\PasselBundle\Traits\HasAttendeesTrait;
use Volleyball\Bundle\UtilityBundle\Traits\SluggableTrait;
use Volleyball\Bundle\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Table(name="passel")
 * @ORM\Entity(repositoryClass="Volleyball\Bundle\PasselBundle\Repository\PasselRepository")
 */
class Passel
{
    use HasAttendeesTrait;
    use SluggableTrait;
    use TimestampableTrait;
    

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
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
     * @Assert\Length(
     *      min = "1",
     *      max = "250",
     *      minMessage = "Name must be at least {{ limit }} characters length",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters length"
     * )
     * @var string
     */
    protected $name;

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
     * Set name
     *
     * @param string $name name
     *
     * @return Passel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="Faction", mappedBy="passel")
     */
    protected $factions;

    /**
     * Get factions
     *
     * @return ArrayCollection
     */
    public function getFactions()
    {
        return $this->factions;
    }

    /**
     * Set factions
     *
     * @param array $factions factions
     *
     * @return self
     */
    public function setFactions(array $factions)
    {
        if (! $factions instanceof ArrayCollection) {
            $factions = new ArrayCollection($factions);
        }

        $this->factions = $factions;

        return $this;
    }

    /**
     * Has factions
     *
     * @return boolean
     */
    public function hasFactions()
    {
        return !$this->factions->isEmpty();
    }

    /**
     * Get a faction
     *
     * @param Faction|String $faction faction
     *
     * @return Faction
     */
    public function getFaction($faction)
    {
        return $this->factions->get($faction);
    }

    /**
     * Add a faction
     *
     * @param Faction $faction faction
     *
     * @return self
     */
    public function addFaction(Faction $faction)
    {
        $this->factions->add($faction);

        return $this;
    }

    /**
     * Remove a faction
     *
     * @param Faction|String $faction faction
     *
     * @return self
     */
    public function removeFaction($faction)
    {
        $this->factions->remove($faction);

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\OrganizationBundle\Entity\Council", inversedBy="passel")
     * @ORM\JoinColumn(name="council_id", referencedColumnName="id")
     */
    protected $council;

    /**
     * Get council
     *
     * @return Council
     */
    public function getCouncil()
    {
        return $this->council;
    }

    /**
     * Set council
     *
     * @param Council $council council
     *
     * @return Council
     */
    public function setCouncil(Council $council)
    {
        $this->council = $council;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\OrganizationBundle\Entity\Region", inversedBy="passel")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region;

    /**
     * Get region
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set region
     *
     * @param Region $region region
     *
     * @return Region
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="Leader", mappedBy="passel")
     */
    protected $leaders;

    /**
     * Get leaders
     *
     * @return ArrayCollection
     */
    public function getLeaders()
    {
        return $this->leaders;
    }

    /**
     * Set leaders
     *
     * @param array $leaders leaders
     *
     * @return self
     */
    public function setLeaders(array $leaders)
    {
        if (! $leaders instanceof ArrayCollection) {
            $leaders = new ArrayCollection($leaders);
        }

        $this->leaders = $leaders;

        return $this;
    }

    /**
     * Has leaders
     *
     * @return boolean
     */
    public function hasLeaders()
    {
        return !$this->leaders->isEmpty();
    }

    /**
     * Add an leader
     *
     * @param Leader $leader leader
     *
     * @return self
     */
    public function addLeader(Leader $leader)
    {
        $this->leaders->add($leader);

        return $this;
    }

    /**
     * Remove an leader
     *
     * @param Leader|String $leader leader
     *
     * @return self
     */
    public function removeLeader($leader)
    {
        $this->leaders->remove($leader);

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Leader", inversedBy="passel")
     * @ORM\JoinColumn(name="leader_id", referencedColumnName="id")
     */
    protected $leader;

    /**
     * Get an leader
     *
     * @param Leader|String $leader leader
     *
     * @return Leader
     */
    public function getLeader($leader)
    {
        return $this->leaders->get($leader);
    }

    /**
     * Set leader
     *
     * @param Leader  $leader    leader
     * @param boolean $addToList addtolist
     *
     * @return Passel|boolean
     */
    public function setLeader(Leader $leader, $addToList = false)
    {
        if (null != $this->leaders->get($leader) || $addToList) {
            $this->leader = $leader;

            return $this;
        }

        return false;
    }

    /**
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\EnrollmentBundle\Entity\PasselEnrollment", mappedBy="passel")
     */
    protected $enrollments;

    /**
     * Get enrollments
     *
     * @return ArrayCollection
     */
    public function getEnrollments()
    {
        return $this->enrollments;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="passel")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;

    /**
     * Get type
     *
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param Type $type type
     *
     * @return type
     */
    public function setType(Type $type)
    {
        if ($this->organization == $type->getOrganization) {
            $this->type = $type;

            return $this;
        }

        return false;
    }

    /**
     * constructor
     */
    public function __construct()
    {
        $this->leaders   = new ArrayCollection();
        $this->factions  = new ArrayCollection();
        $this->attendees = new ArrayCollection();
    }
}
