<?php
namespace Volleyball\FacilityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Volleyball\UtilityBundle\Traits\SluggableTrait;
use Volleyball\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="department")
 */
class Department
{
    use SluggableTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Name
     * @var  string name
     * @ORM\Column(name="name", type="string")
     */
    protected $name = '';

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
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Description
     *
     * @var string
     */
    protected $description = '';

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
     * @param string $description description
     *
     * @return string
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Department", inversedBy="department")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $department = null;

    /**
     * Get department
     *
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set department
     *
     * @param Department $department department
     *
     * @return Leader
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Facility", inversedBy="department")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    protected $facility = '';

    /**
     * Get facility
     *
     * @return Facility
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * Set facility
     *
     * @param Facility $facility facility
     *
     * @return Leader
     */
    public function setFacility(Facility $facility)
    {
        $this->facility = $facility;

        return $this;
    }
}
