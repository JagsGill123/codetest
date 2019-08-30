<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Common\Entity\AbstractEntity;
use App\Common\Entity\Traits\HasCodeTrait;
use App\Common\Entity\Traits\HasIdTrait;
use App\Common\Entity\Traits\HasSymbolTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 */
class Currency extends AbstractEntity
{
    use HasIdTrait,
        HasCodeTrait,
        HasSymbolTrait;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Country", mappedBy="currencies")
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
            $country->addCurrency($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
            $country->removeCurrency($this);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'code' => $this->getCode(),
            'symbol' => $this->getSymbol(),
        ];
    }
}
