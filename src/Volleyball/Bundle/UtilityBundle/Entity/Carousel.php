<?php
namespace Volleyball\Bundle\UtilityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Volleyball\Component\Utility\Model\Carousel as BaseCarousel;
use Volleyball\Bundle\UtilityBundle\Entity\CarouselItem;
use Volleyball\Bundle\UtilityBundle\Traits\EntityBootstrapTrait;
use Volleyball\Bundle\UtilityBundle\Traits\SluggableTrait;
use Volleyball\Bundle\UtilityBundle\Traits\TimestampableTrait;

/**
* @ORM\Entity
* @ORM\Table(name="carousel")
*/
class Carousel extends BaseCarousel
{
    use EntityBootstrapTrait;
    use SluggableTrait;
    use TimestampableTrait;

    /**
     * @ORM\OneToMany(targetEntity="CarouselItem", mappedBy="carousel")
     */
    protected $items;

    /**
     * Get items
     *
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set items
     *
     * @param array $items items
     *
     * @return self
     */
    public function setItems(array $items)
    {
        if (! $items instanceof ArrayCollection) {
            $items = new ArrayCollection($items);
        }

        $this->items = $items;

        return $this;
    }

    /**
     * Has items
     *
     * @return boolean
     */
    public function hasItems()
    {
        return !$this->items->isEmpty();
    }

    /**
     * Get a item
     *
     * @param CarouselItem|String $item item
     *
     * @return CarouselItem
     */
    public function getItem($item)
    {
        return $this->items->get($item);
    }

    /**
     * Add a item
     *
     * @param CarouselItem $item item
     *
     * @return self
     */
    public function addItem(CarouselItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove a item
     *
     * @param CarouselItem|String $item item
     *
     * @return self
     */
    public function removeItem(CarouselItem $item)
    {
        unset($this->items[$item]);

        return $this;
    }
}
