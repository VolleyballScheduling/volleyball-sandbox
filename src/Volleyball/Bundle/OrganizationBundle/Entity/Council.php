<?php
namespace Volleyball\Bundle\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Volleyball\Bundle\UtilityBundle\Traits\SluggableTrait;
use Volleyball\Bundle\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass="Volleyball\Bundle\OrganizationBundle\Repository\CouncilRepository")
 * @ORM\Table(name="council")
 */
class Council
{
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
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description string
     *
     * @return Organization
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    protected $organization;

    public function getOrganization()
    {
        return $this->organization;
    }

    public function setOrganization(Volleyball\Bundle\OrganizationBundle\Entity\Organization $organization)
    {
        $this->organization = $organization;

        return $this;
    }
    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="council")
     */
    protected $regions;

    /**
     * Get regions
     *
     * @return ArrayCollection
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Set regions
     *
     * @param array $regions regions
     *
     * @return self
     */
    public function setRegions(array $regions)
    {
        if (! $regions instanceof ArrayCollection) {
            $regions = new ArrayCollection($regions);
        }

        $this->regions = $regions;

        return $this;
    }

    /**
     * Has regions
     *
     * @return boolean
     */
    public function hasRegions()
    {
        return !$this->regions->isEmpty();
    }

    /**
     * Get an region
     *
     * @param Region|String $region region
     *
     * @return Region
     */
    public function getRegion($region)
    {
        return $this->regions->get($region);
    }

    /**
     * Add an region
     *
     * @param Region $region region
     *
     * @return self
     */
    public function addRegion(Region $region)
    {
        $this->regions->add($region);

        return $this;
    }

    /**
     * Remove an region
     *
     * @param Region|String $region region
     *
     * @return self
     */
    public function removeRegion($region)
    {
        $this->regions->remove($region);

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\PasselBundle\Entity\Passel", mappedBy="council")
     */
    protected $passels;

    /**
     * Get passels
     *
     * @return ArrayCollection
     */
    public function getPassels()
    {
        return $this->passels;
    }

    /**
     * Set passels
     *
     * @param array $passels passels
     *
     * @return self
     */
    public function setPassels(array $passels)
    {
        if (! $passels instanceof ArrayCollection) {
            $passels = new ArrayCollection($passels);
        }

        $this->passels = $passels;

        return $this;
    }

    /**
     * Has passels
     *
     * @return boolean
     */
    public function hasPassels()
    {
        return !$this->passels->isEmpty();
    }

    /**
     * Get an passel
     *
     * @param Passel|String $passel passel
     *
     * @return Passel
     */
    public function getPassel($passel)
    {
        return $this->passels->get($passel);
    }

    /**
     * Add an passel
     *
     * @param Passel $passel passel
     *
     * @return self
     */
    public function addPassel(Passel $passel)
    {
        $this->passels->add($passel);

        return $this;
    }

    /**
     * Remove an passel
     *
     * @param Passel|String $passel passel
     *
     * @return self
     */
    public function removePassel($passel)
    {
        $this->passels->remove($passel);

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\FacilityBundle\Entity\Facility", mappedBy="council")
     */
    protected $facilities;

    /**
     * Get facilities
     *
     * @return ArrayCollection
     */
    public function getFacilities()
    {
        return $this->facilities;
    }

    /**
     * Set facilities
     *
     * @param array $facilities facilities
     *
     * @return self
     */
    public function setFacilities(array $facilities)
    {
        if (! $facilities instanceof ArrayCollection) {
            $facilities = new ArrayCollection($facilities);
        }

        $this->facilities = $facilities;

        return $this;
    }

    /**
     * Has facilities
     *
     * @return boolean
     */
    public function hasFacilities()
    {
        return !$this->facilities->isEmpty();
    }

    /**
     * Get an facility
     *
     * @param Facility|String $facility facility
     *
     * @return Facility
     */
    public function getFacility($facility)
    {
        return $this->facilities->get($facility);
    }

    /**
     * Add an facility
     *
     * @param Facility $facility facility
     *
     * @return self
     */
    public function addFacility(Facility $facility)
    {
        $this->facilities->add($facility);

        return $this;
    }

    /**
     * Remove an facility
     *
     * @param Facility|String $facility facility
     *
     * @return self
     */
    public function removeFacility($facility)
    {
        $this->facilities->remove($facility);

        return $this;
    }

        /**
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\FacilityBundle\Entity\Faculty", mappedBy="council")
     */
    protected $facultys;

    /**
     * Get facultys
     *
     * @return ArrayCollection
     */
    public function getFacultys()
    {
        return $this->facultys;
    }

    /**
     * Set facultys
     *
     * @param array $facultys facultys
     *
     * @return self
     */
    public function setFacultys(array $facultys)
    {
        if (! $facultys instanceof ArrayCollection) {
            $facultys = new ArrayCollection($facultys);
        }

        $this->facultys = $facultys;

        return $this;
    }

    /**
     * Has faculty
     *
     * @return boolean
     */
    public function hasFaculty()
    {
        return !$this->facultys->isEmpty();
    }

    /**
     * Get an faculty
     *
     * @param Faculty|String $faculty faculty
     *
     * @return Faculty
     */
    public function getFaculty($faculty)
    {
        return $this->facultys->get($faculty);
    }

    /**
     * Add an faculty
     *
     * @param Faculty $faculty faculty
     *
     * @return self
     */
    public function addFaculty(Faculty $faculty)
    {
        $this->facultys->add($faculty);

        return $this;
    }

    /**
     * Remove an faculty
     *
     * @param Faculty|String $faculty faculty
     *
     * @return self
     */
    public function removeFaculty($faculty)
    {
        $this->facultys->remove($faculty);

        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->passels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facilities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facultys = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
