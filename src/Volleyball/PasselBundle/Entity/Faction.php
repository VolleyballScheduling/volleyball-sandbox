<?php
namespace Volleyball\PasselBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Volleyball\PasselBundle\Entity\Passel;
use Volleyball\PasselBundle\Traits\HasAttendeesTrait;
use Volleyball\UtilityBundle\Traits\SluggableTrait;
use Volleyball\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass="Volleyball\PasselBundle\Repository\FactionRepository")
 * @ORM\Table(name="faction")
 */
class Faction
{
    use HasAttendeesTrait;
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
     * Avatar
     * @var string avatar
     * @ORM\Column(name="avatar", type="text")
     */
    protected $avatar = '';

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatar
     *
     * @param string $avatar avatar
     *
     * @return self
     */
    public function setAvatar($avatar = '')
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Volleyball\PasselBundle\Entity\Passel", inversedBy="faction")
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
}
