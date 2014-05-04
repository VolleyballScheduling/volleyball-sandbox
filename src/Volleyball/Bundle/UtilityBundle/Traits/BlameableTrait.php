<?php
namespace Volleyball\Bundle\UtilityBundle\traits;

use Volleyball\Bundle\UserBundle\Entity\User;

trait BlameableTrait
{
    /**
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\UserBundle\Entity\User", mappedBy="passel")
     */
    protected $created_by;

    /**
     * @inheritdoc
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @inheritdoc
     */
    public function setCreatedBy(Volleyball\Bundle\UserBundle\Entity\User $user)
    {
        $this->created_by = $user;

        return $user;
    }

    /**
     * Document Update Author
     * @var Volleyball\Bundle\UserBundle\Document\User
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\UserBundle\Entity\User", mappedBy="passel")
     */
    protected $updated_by;

    /**
     * @inheritdoc
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @inheritdoc
     */
    public function setUpdatedBy(Volleyball\Bundle\UserBundle\Entity\User $user)
    {
        $this->updated_by = $user;

        return $this;
    }
}
