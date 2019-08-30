<?php

namespace App\Entity;

use App\Common\Entity\Traits\HasNameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Common\Entity\AbstractEntity;
use App\Common\Entity\Traits\HasIdTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeZoneRepository")
 */
class TimeZone extends AbstractEntity
{
    use HasIdTrait,
        HasNameTrait;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Country", mappedBy="timezone")
     */
    private $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    /**
     * @return Collection|Country[]
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->countries->contains($country)) {
            $this->countries[] = $country;
            $country->addTimezone($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
            $country->removeTimezone($this);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
