<?php
namespace Volleyball\UtilItybundLe\traits;

trait GeolocatableTrait
{
    /**
     * Latitude
     * @var float
     * @ORM\Column(type="decimal", scale=3)
     */
    protected $latitude = null;

    /**
     * Get latitude
     *
     * @return Float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @param float $lat latitude
     *
     * @return self
     */
    public function setLatitude($lat)
    {
        $this->latitude = $lat;

        return $this;
    }

    /**
     * Longitude
     * @var float
     * @ORM\Column(type="decimal", scale=3)
     */
    protected $longitude = null;

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @param float $lng longitude
     *
     * @return self
     */
    public function setLongitude($lng)
    {
        $this->longitude = $lng;

        return $this;
    }

    /**
     * Get coords
     *
     * @param boolean $asString return as string
     *
     * return array|string
     */
    public function getCoords($asString = false)
    {
        if ($asString) {
            return $this->getLatitude().', '.$this->getLongitude();
        }

        return array($this->getLatitude(), $this->getLongitude());
    }

    /**
     * Set coords
     *
     * @param array|float $lat latitude or array or coords
     * @param float       $lng longitude
     *
     * @return self
     */
    public function setCoords($lat, $lng = null)
    {
        if (!is_array($lat) && null == $lng) {
            return false;
        } elseif (is_array($lat)) {
            $this->setLatitude($lat['lat'])->setLongitude($lat['lng']);
        } else {
            $this->setLatitude($lat)->setLongitude($lng);
        }

        return $this;
    }

    /**
     * Set latitude and longitude
     *
     * @param array $latlng latitude and longitude
     *
     * @return self
     */
    public function setLatLng($latlng)
    {
        $this->setLatitude($latlng['lat']);
        $this->setLongitude($latlng['lng']);

        return $this;
    }

    /**
     * @Assert\NotBlank()
     * @OhAssert\LatLng()
     */
    public function getLatLng()
    {
        return array('lat'=>$this->getLatitude(),'lng'=>$this->getLongitude());
    }

}
