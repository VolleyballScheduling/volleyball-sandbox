<?php
namespace Volleyball\Bundle\EnrollmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Volleyball\Bundle\OrganizationBundle\Entity\Organization;
use Volleyball\Bundle\OrganizationBundle\Entity\Council;
use Volleyball\Bundle\OrganizationBundle\Entity\Region;
use Volleyball\Bundle\PasselBundle\Entity\Passel;
use Volleyball\Bundle\PasselBundle\Entity\Attendee;
use Volleyball\Bundle\PasselBundle\Entity\Leader;
use Volleyball\Bundle\FacilityBundle\Entity\Facility;
use Volleyball\Bundle\UserBundle\Entity\User;

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
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\OrganizationBundle\Entity\Organization", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     */
    protected $organization = null;

    /**
     * Get Organization
     *
     * @return Volleyball\Bundle\OrganizationBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set Organization
     *
     * @param \Volleyball\Bundle\OrganizatonBundle\Entity\Organization $organization
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setOrganization(Organization $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\OrganizationBundle\Entity\Council", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="council_id", referencedColumnName="id")
     */
    protected $council = null;

    /**
     * Get Council
     *
     * @return Volleyball\Bundle\OrganizationBundle\Entity\Council
     */
    public function getCouncil()
    {
        return $this->council;
    }

    /**
     * Set Council
     *
     * @param \Volleyball\Bundle\OrganizationBundle\Entity\Council $council
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setCouncil(Council $council)
    {
        $this->council = $council;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\OrganizationBundle\Entity\Region", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    protected $region = null;

    /**
     * Get Region
     *
     * @return Volleyball\Bundle\OrganizationBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set Region
     *
     * @param \Volleyball\Bundle\OrganizationBundle\Entity\Region $region
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\PasselBundle\Entity\Passel", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="passel_id", referencedColumnName="id")
     */
    protected $passel;

    /**
     * Get Passel
     *
     * @return Volleyball\Bundle\PasselBundle\Entity\Passel
     */
    public function getPassel()
    {
        return $this->passel;
    }

    /**
     * Set Passel
     *
     * @param \Volleyball\Bundle\PasselBundle\Entity\Passel $passel
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setPassel(Passel $passel)
    {
        $this->passel = $passel;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\PasselBundle\Entity\Attendee", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="attendee_id", referencedColumnName="id")
     */
    protected $attendee = null;

    /**
     * Get Attendee
     *
     * @return Volleyball\Bundle\PasselBundle\Entity\Attendee
     */
    public function getAttendee()
    {
        return $this->attendee;
    }

    /**
     * Set Attendee
     *
     * @param \Volleyball\Bundle\PasselBundle\Entity\Attendee $attendee
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setAttendee(Attendee $attendee)
    {
        $this->attendee = $attendee;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\PasselBundle\Entity\Leader", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="leader_id", referencedColumnName="id")
     */
    protected $leader = null;

    /**
     * Get Leader
     *
     * @return Volleyball\Bundle\PasselBundle\Entity\Leader
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Set Leader
     *
     * @param \Volleyball\Bundle\PasselBundle\Entity\Leader $leader
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setLeader(Leader $leader)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\FacilityBundle\Entity\Facility", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    protected $facility;

    /**
     * Get Facility
     *
     * @return Volleyball\Bundle\FacilityBundle\Entity\Facility
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * Set Facility
     *
     * @param \Volleyball\Bundle\FacilityBundle\Entity\Facility $facility
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setFacility(Facility $facility)
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\EnrollmentBundle\Entity\Season", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    protected $season;

    /**
     * Get Season
     *
     * @return Volleyball\Bundle\EnrollmentBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set Season
     * @param \Volleyball\Bundle\EnrollmentBundle\Entity\Season $season
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setSeason(Season $season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\EnrollmentBundle\Entity\Week", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="week_id", referencedColumnName="id")
     */
    protected $week;

    /**
     * Get Week
     *
     * @return Volleyball\Bundle\EnrollmentBundle\Entity\Week
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set Week
     * @param \Volleyball\Bundle\EnrollmentBundle\Entity\Week $week
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setWeek(Week $week)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\Bundle\UserBundle\Entity\User", inversedBy="active_enrollment")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * Get User
     *
     * @return Volleyball\Bundle\EnrollmentBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set User
     * @param \Volleyball\Bundle\EnrollmentBundle\Entity\User $user
     * @return \Volleyball\Bundle\EnrollmentBundle\Entity\ActiveEnrollment
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

}
