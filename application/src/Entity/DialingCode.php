<?php

namespace App\Entity;

use App\Common\Entity\Traits\HasCodeTrait;
use App\Common\Entity\Traits\HasIdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DialingCodeRepository")
 */
class DialingCode
{
    use HasIdTrait,
        HasCodeTrait;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Country", mappedBy="dialingCodes")
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
            $country->addDialingCode($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
            $country->removeDialingCode($this);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'code' => $this->getCode(),
        ];
    }
}
