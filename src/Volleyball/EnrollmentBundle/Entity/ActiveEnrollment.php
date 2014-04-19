<?php
namespace Volleyball\EnrollmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Volleyball\OrganizationBundle\Entity\Organization;
use Volleyball\OrganizationBundle\Entity\Council;
use Volleyball\OrganizationBundle\Entity\Region;
use Volleyball\PasselBundle\Entity\Passel;
use Volleyball\PasselBundle\Entity\Attendee;
use Volleyball\PasselBundle\Entity\Leader;
use Volleyball\FacilityBundle\Entity\Facility;
use Volleyball\UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="active_enrollment")
 */
class ActiveEnrollment
{
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
     * @ORM\ManyToOne(targetEntity="Volleyball\OrganizationBundle\Entity\Organization", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     */
    protected $organization = null;

    /**
     * Get Organization
     *
     * @return Volleyball\OrganizationBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set Organization
     *
     * @param \Volleyball\OrganizatonBundle\Entity\Organization $organization
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\OrganizationBundle\Entity\Council", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="council_id", referencedColumnName="id")
     */
    protected $council = null;

    /**
     * Get Council
     *
     * @return Volleyball\OrganizationBundle\Entity\Council
     */
    public function getCouncil()
    {
        return $this->council;
    }

    /**
     * Set Council
     *
     * @param \Volleyball\OrganizationBundle\Entity\Council $council
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setCouncil(Council $council)
    {
        $this->council = $council;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\OrganizationBundle\Entity\Region", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region = null;

    /**
     * Get Region
     *
     * @return Volleyball\OrganizationBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set Region
     *
     * @param \Volleyball\OrganizationBundle\Entity\Region $region
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\PasselBundle\Entity\Passel", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="passel_id", referencedColumnName="id")
     */
    protected $passel;

    /**
     * Get Passel
     *
     * @return Volleyball\PasselBundle\Entity\Passel
     */
    public function getPassel()
    {
        return $this->passel;
    }

    /**
     * Set Passel
     *
     * @param \Volleyball\PasselBundle\Entity\Passel $passel
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setPassel(Passel $passel)
    {
        $this->passel = $passel;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\PasselBundle\Entity\Attendee", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="attendee_id", referencedColumnName="id")
     */
    protected $attendee = null;

    /**
     * Get Attendee
     *
     * @return Volleyball\PasselBundle\Entity\Attendee
     */
    public function getAttendee()
    {
        return $this->attendee;
    }

    /**
     * Set Attendee
     *
     * @param \Volleyball\PasselBundle\Entity\Attendee $attendee
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setAttendee(Attendee $attendee)
    {
        $this->attendee = $attendee;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\PasselBundle\Entity\Leader", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="leader_id", referencedColumnName="id")
     */
    protected $leader = null;

    /**
     * Get Leader
     *
     * @return Volleyball\PasselBundle\Entity\Leader
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Set Leader
     *
     * @param \Volleyball\PasselBundle\Entity\Leader $leader
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setLeader(Leader $leader)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Facility", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    protected $facility;

    /**
     * Get Facility
     *
     * @return Volleyball\FacilityBundle\Entity\Facility
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * Set Facility
     *
     * @param \Volleyball\FacilityBundle\Entity\Facility $facility
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setFacility(Facility $facility)
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\EnrollmentBundle\Entity\Season", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    protected $season;

    /**
     * Get Season
     *
     * @return Volleyball\EnrollmentBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set Season
     * @param \Volleyball\EnrollmentBundle\Entity\Season $season
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setSeason(Season $season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\EnrollmentBundle\Entity\Week", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="week_id", referencedColumnName="id")
     */
    protected $week;

    /**
     * Get Week
     *
     * @return Volleyball\EnrollmentBundle\Entity\Week
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set Week
     * @param \Volleyball\EnrollmentBundle\Entity\Week $week
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setWeek(Week $week)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\UserBundle\Entity\User", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * Get User
     *
     * @return Volleyball\EnrollmentBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set User
     * @param \Volleyball\EnrollmentBundle\Entity\User $user
     * @return \Volleyball\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

}
