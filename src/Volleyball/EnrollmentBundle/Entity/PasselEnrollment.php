<?php
namespace Volleyball\EnrollmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Volleyball\UtilityBundle\Traits\TimestampableTrait;
use Volleyball\PasselBundle\Entity\Passel;
use Volleyball\FacilityBundle\Entity\Quarters;
use Volleyball\FacilityBundle\Entity\Facility;
use Volleyball\EnrollmentBundle\Entity\Week;
use Volleyball\EnrollmentBundle\Entity\Season;

/**
 * @ORM\Entity(repositoryClass="Volleyball\EnrollmentBundle\Repository\PasselEnrollmentCollectionRepository")
 * @ORM\Table(name="passel_enrollment")
 */
class PasselEnrollment
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\PasselBundle\Entity\Passel", inversedBy="passel_enrollment")
     * @ORM\JoinColumn(name="passel_id", referencedColumnName="id")
     */
    protected $passel;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Facility", inversedBy="passel_enrollment")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    protected $facility;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\EnrollmentBundle\Entity\Week", inversedBy="passel_enrollment")
     * @ORM\JoinColumn(name="week_id", referencedColumnName="id")
     */
    protected $week;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\EnrollmentBundle\Entity\Season", inversedBy="passel_enrollment")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    protected $season;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Quarters", inversedBy="passel_enrollment")
     * @ORM\JoinColumn(name="quarters_id", referencedColumnName="id")
     */
    protected $quarters;

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
     * Set passel
     *
     * @param Volleyball\PasselBundle\Entity\Passel $passel
     * @return PasselEnrollment
     */
    public function setPassel(Passel $passel = null)
    {
        $this->passel = $passel;

        return $this;
    }

    /**
     * Get passel
     *
     * @return \Volleyball\PasselBundle\Entity\Passel
     */
    public function getPassel()
    {
        return $this->passel;
    }

    /**
     * Set facility
     *
     * @param Volleyball\FacilityBundle\Entity\Facility $facility
     * @return PasselEnrollment
     */
    public function setFacility(Facility $facility = null)
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * Get facility
     *
     * @return Volleyball\FacilityBundle\Entity\Facility
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * Set week
     *
     * @param Volleyball\EnrollmentBundle\Entity\Week $week
     * @return PasselEnrollment
     */
    public function setWeek(Week $week = null)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Get week
     *
     * @return Volleyball\EnrollmentBundle\Entity\Week
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set season
     *
     * @param Volleyball\EnrollmentBundle\Entity\Season $season
     * @return PasselEnrollment
     */
    public function setSeason(Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return Volleyball\EnrollmentBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set quarters
     *
     * @param Volleyball\FacilityBundle\Entity\Quarters $quarters
     * @return PasselEnrollment
     */
    public function setQuarters(Quarters $quarters = null)
    {
        $this->quarters = $quarters;

        return $this;
    }

    /**
     * Get quarters
     *
     * @return Volleyball\FacilityBundle\Entity\Quarters
     */
    public function getQuarters()
    {
        return $this->quarters;
    }
}
