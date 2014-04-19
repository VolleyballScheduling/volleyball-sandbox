<?php
namespace Volleyball\EnrollmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Volleyball\EnrollmentBundle\Repository\AttendeeEnrollmentCollectionRepository")
 * @ORM\Table(name="attendee_enrollment_collection")
 */
class AttendeeEnrollmentCollection
{
    public function __construct()
    {
        $this->enrollments = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AttendeeEnrollment", mappedBy="attendee_enrollment_collection")
     */
    protected $enrollments;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\PasselBundle\Entity\Attendee", inversedBy="attendee_enrollment_collection")
     * @ORM\JoinColumn(name="attendee_id", referencedColumnName="id")
     */
    protected $attendee;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Facility", inversedBy="attendee_enrollment_collection")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    protected $facility;

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\EnrollmentBundle\Entity\Week", inversedBy="attendee_enrollment_collection")
     * @ORM\JoinColumn(name="week_id", referencedColumnName="id")
     */
    protected $week;

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
     * Add enrollments
     *
     * @param Volleyball\EnrollmentBundle\Entity\AttendeeEnrollment $enrollments
     * @return AttendeeEnrollmentCollection
     */
    public function addEnrollment(Volleyball\EnrollmentBundle\Entity\AttendeeEnrollment $enrollments)
    {
        $this->enrollments[] = $enrollments;

        return $this;
    }

    /**
     * Remove enrollments
     *
     * @param Volleyball\EnrollmentBundle\Entity\AttendeeEnrollment $enrollments
     */
    public function removeEnrollment(Volleyball\EnrollmentBundle\Entity\AttendeeEnrollment $enrollments)
    {
        $this->enrollments->removeElement($enrollments);
    }

    /**
     * Get enrollments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnrollments()
    {
        return $this->enrollments;
    }

    /**
     * Set attendee
     *
     * @param Volleyball\PasselBundle\Entity\Attendee $attendee
     * @return AttendeeEnrollmentCollection
     */
    public function setAttendee(Volleyball\PasselBundle\Entity\Attendee $attendee = null)
    {
        $this->attendee = $attendee;

        return $this;
    }

    /**
     * Get attendee
     *
     * @return Volleyball\PasselBundle\Entity\Attendee
     */
    public function getAttendee()
    {
        return $this->attendee;
    }

    /**
     * Set facility
     *
     * @param Volleyball\FacilityBundle\Entity\Facility $facility
     * @return AttendeeEnrollmentCollection
     */
    public function setFacility(Volleyball\FacilityBundle\Entity\Facility $facility = null)
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
     * @return AttendeeEnrollmentCollection
     */
    public function setWeek(Volleyball\CourseBundle\Entity\Week $week = null)
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
}
