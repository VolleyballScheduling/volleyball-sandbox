<?php
namespace Volleyball\FacilityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

use Volleyball\UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="faculty")
 * @UniqueEntity(fields = "username", targetClass = "Volleyball\UserBundle\Entity\User", message="fos_user.username_already")
 * @UniqueEntity(fields = "email", targetClass = "Volleyball\UserBundle\Entity\User", message="fos_user.email_already")
 */
class Faculty extends User
{
    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\FacilityBundle\Entity\Position", inversedBy="faculty")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     */
    protected $position;

    /**
     * Get position
     *
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param Position $position position
     *
     * @return Faculty
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;

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

    protected $quarters;

    /**
     * Get quarters
     *
     * @return Quarters
     */
    public function getQuarters($type)
    {
        return $this->quarters->filterByType($type);
    }

    /**
     * Set quarters
     *
     * @param Quarters $quarters quarters
     *
     * @return Faculty
     */
    public function setQuarters(Quarters $quarters)
    {
        $this->quarters = $quarters;

        return $this;
    }

    protected $quarters_types = array();

    /**
     * Admin - if true, user can make limited changes to the passel
     * @var boolean
     */
    protected $admin = false;

    /**
     * Is admin
     *
     * @param boolean $admin admin
     *
     * @return boolean|Faculty
     */
    public function isAdmin($admin = null)
    {
        if (null != $admin) {
            $this->admin = $admin;

            return $this;
        }

        return $thus->admin;
    }
}
