<?php
namespace Volleyball\EnrollmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Volleyball\EnrollmentBundle\Entity\Week;
use Volleyball\EnrollmentBundle\Entity\Period;
use Volleyball\FacilityBundle\Entity\Facility;
use Volleyball\UtilityBundle\Traits\SluggableTrait;
use Volleyball\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Table(name="season")
 * @ORM\Entity(repositoryClass="Volleyball\EnrollmentBundle\Repository\SeasonRepository")
 */
class Season
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
     * @return Season
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @ORM\Column(name="year", type="date")
     * @var DateTime $year
     */
    protected $year;

    /**
     * Get year
     *
     * @param  boolean $long year format
     * @return string
     */
    public function getYear($long = true)
    {
        if (!$long) {
            return date('Y', $this->year);
        }

        return date('y', $this->year);
    }

    /**
     * Set year
     *
     * @param  DateTime $year year
     * @return Year
     */
    public function setYear(\DateTime $year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Facility", inversedBy="facility")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    protected $facility;

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
     * @return Faculty
     */
    public function setFacility(Facility $facility)
    {
        $this->facility = $facility;

        return $this;
    }
}
