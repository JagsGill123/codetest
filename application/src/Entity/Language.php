<?php

namespace App\Entity;

use App\Common\Entity\Traits\HasCodeTrait;
use App\Common\Entity\Traits\HasIdTrait;
use App\Common\Entity\Traits\HasNameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
{
    use HasIdTrait,
        HasNameTrait,
        HasCodeTrait;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Country", mappedBy="languages")
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
            $country->addLanguage($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
            $country->removeLanguage($this);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'code' => $this->getCode(),
            'name' => $this->getName(),
        ];
    }
}
