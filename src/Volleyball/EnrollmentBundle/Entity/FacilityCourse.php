<?php
namespace Volleyball\EnrollmentBundle\Entity;

use Volleyball\UtilityBundle\Traits\SluggableTrait;
use Volleyball\UtilityBundle\Traits\TimestampableTrait;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Volleyball\CourseBundle\Entity\Course;
use Volleyball\FacilityBundle\Entity\Facility;
use Volleyball\EnrollmentBundle\Entity\Season;

/**
 * @ORM\Entity(repositoryClass="Volleyball\EnrollmentBundle\Repository\FacilityCourseRepository")
 * @ORM\Table(name="facility_enrollment")
 */
class FacilityCourse
{
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
     * @ORM\ManyToOne(targetEntity="Volleyball\CourseBundle\Entity\Course", inversedBy="facility_course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    protected $course = null;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Facility", inversedBy="facility_enrollments")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    protected $facility = null;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\EnrollmentBundle\Entity\Season", inversedBy="facility_course")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    protected $season = null;

    /**
     * Set course
     *
     * @param \Volleyball\CourseBundle\Entity\Course $course
     * @return FacilityCourse
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return Volleyball\CourseBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set facility
     *
     * @param Volleyball\FacilityBundle\Entity\Facility $facility
     * @return FacilityCourse
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
     * Set season
     *
     * @param Volleyball\EnrollmentBundle\Entity\Season $season
     * @return FacilityCourse
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
}
