<?php
namespace Volleyball\PasselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

use Volleyball\UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="passel_leader")
 * @UniqueEntity(fields = "username", targetClass = "Volleyball\UserBundle\Entity\User", message="fos_user.username_already")
 * @UniqueEntity(fields = "email", targetClass = "Volleyball\UserBundle\Entity\User", message="fos_user.email_already")
 */
class Leader extends User
{
    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\PasselBundle\Entity\Passel", inversedBy="leader")
     * @ORM\JoinColumn(name="passel_id", referencedColumnName="id")
     */
    protected $passel = '';

    /**
     * Get passel
     *
     * @return Passel
     */
    public function getPassel()
    {
        return $this->passel;
    }

    /**
     * Set passel
     *
     * @param Passel $passel passel
     *
     * @return Leader
     */
    public function setPassel(Passel $passel)
    {
        $this->passel = $passel;

        return $this;
    }

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
     * @return boolean|Leader
     */
    public function isAdmin($admin = null)
    {
        if (null != $admin && is_bool($admin)) {
            $this->admin = $admin;

            return $this;
        }

        return $this->admin;
    }

    /**
     * Primary
     * @var boolean
     */
    protected $primary = false;

    /**
     * Is primary
     *
     * @param boolean $primary primary
     *
     * @return boolean|Leader
     */
    public function isPrimary($primary = null)
    {
        if (null != $primary) {
            $this->primary = $primary;

            return $this;
        }

        return $this->primary;
    }
}
