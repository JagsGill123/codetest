<?php

namespace App\Entity;

use App\Common\Entity\AbstractEntity;
use App\Common\Entity\Traits\HasCapitalTrait;
use App\Common\Entity\Traits\HasFlagTrait;
use App\Common\Entity\Traits\HasIdTrait;
use App\Common\Entity\Traits\HasNameTrait;
use App\Common\Entity\Traits\HasRegionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country extends AbstractEntity
{
    use HasIdTrait,
        HasCapitalTrait,
        HasFlagTrait,
        HasRegionTrait,
        HasNameTrait;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CountryCode", inversedBy="countries")
     */
    private $countryCode;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TimeZone", inversedBy="countries")
     */
    private $timezone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Currency", inversedBy="countries")
     */
    private $currencies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Language", inversedBy="countries")
     */
    private $languages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DialingCode", inversedBy="countries")
     */
    private $dialingCodes;

    public function __construct()
    {
        $this->countryCode = new ArrayCollection();
        $this->timezone = new ArrayCollection();
        $this->currencies = new ArrayCollection();
        $this->languages = new ArrayCollection();
        $this->dialingCodes = new ArrayCollection();
    }

    /**
     * @return Collection|CountryCode[]
     */
    public function getCountryCode(): Collection
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCountryCodeAttribute(): string
    {
        $values = $this->getCountryCode()->map(function (CountryCode $countryCode) {
            return $countryCode->getCode();
        });

        return join(', ', $values->toArray());
    }

    public function addCountryCode(CountryCode $countryCode): self
    {
        if (!$this->countryCode->contains($countryCode)) {
            $this->countryCode[] = $countryCode;
        }

        return $this;
    }

    public function removeCountryCode(CountryCode $countryCode): self
    {
        if ($this->countryCode->contains($countryCode)) {
            $this->countryCode->removeElement($countryCode);
        }

        return $this;
    }

    /**
     * @return Collection|TimeZone[]
     */
    public function getTimezone(): Collection
    {
        return $this->timezone;
    }

    /**
     * @return string
     */
    public function getTimezoneAttribute(): string
    {
        $values = $this->getTimezone()->map(function (TimeZone $timeZone) {
            return $timeZone->getName();
        });

        return join(', ', $values->toArray());
    }

    public function addTimezone(TimeZone $timezone): self
    {
        if (!$this->timezone->contains($timezone)) {
            $this->timezone[] = $timezone;
        }

        return $this;
    }

    public function removeTimezone(TimeZone $timezone): self
    {
        if ($this->timezone->contains($timezone)) {
            $this->timezone->removeElement($timezone);
        }

        return $this;
    }

    /**
     * @return Collection|Currency[]
     */
    public function getCurrencies(): Collection
    {
        return $this->currencies;
    }

    /**
     * @return string
     */
    public function getCurrenciesAttribute(): string
    {
        $values = $this->getCurrencies()->map(function (Currency $currency) {
            return $currency->getCode() . ' - ' . $currency->getSymbol();
        });

        return join(', ', $values->toArray());
    }

    public function addCurrency(Currency $currency): self
    {
        if (!$this->currencies->contains($currency)) {
            $this->currencies[] = $currency;
        }

        return $this;
    }

    public function removeCurrency(Currency $currency): self
    {
        if ($this->currencies->contains($currency)) {
            $this->currencies->removeElement($currency);
        }

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    /**
     * @return string
     */
    public function getLanguagesAttribute(): string
    {
        $values = $this->getLanguages()->map(function (Language $language) {
            return $language->getName() . ' - ' . $language->getCode();
        });

        return join(', ', $values->toArray());
    }


    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        if ($this->languages->contains($language)) {
            $this->languages->removeElement($language);
        }

        return $this;
    }

    /**
     * @return Collection|DialingCode[]
     */
    public function getDialingCodes(): Collection
    {
        return $this->dialingCodes;
    }

    /**
     * @return string
     */
    public function getDialingCodesAttribute(): string
    {
        $values = $this->getDialingCodes()->map(function (DialingCode $dialingCode) {
            return $dialingCode->getCode();
        });

        return join(', ', $values->toArray());
    }

    public function addDialingCode(DialingCode $dialingCode): self
    {
        if (!$this->dialingCodes->contains($dialingCode)) {
            $this->dialingCodes[] = $dialingCode;
        }

        return $this;
    }

    public function removeDialingCode(DialingCode $dialingCode): self
    {
        if ($this->dialingCodes->contains($dialingCode)) {
            $this->dialingCodes->removeElement($dialingCode);
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'capital' => $this->getCapital(),
            'region' => $this->getRegion(),
            'countryCode' => $this->getCountryCodeAttribute(),
            'timezone' => $this->getTimezoneAttribute(),
            'currencies' => $this->getCurrenciesAttribute(),
            'dialingCodes' => $this->getDialingCodesAttribute(),
            'languages' => $this->getLanguagesAttribute(),
            'flag' => $this->getFlag(),
        ];
    }
}
