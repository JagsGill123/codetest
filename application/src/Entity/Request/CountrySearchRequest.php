<?php

namespace App\Entity\Request;

use Symfony\Component\Validator\Constraints as Assert;


class CountrySearchRequest
{
    /**
     * @Assert\Length(min="1", max="250")
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $countryCodes;

    /**
     * @return array
     */
    public function getCountryCodesAttribute(): array
    {
        return $this->countryCodes ? explode(',', $this->countryCodes) : [];
    }

    /**
     * @Assert\Length(min="1", max="250")
     * @var string
     */
    public $capital;

    /**
     * @Assert\Length(min="1", max="250")
     * @var string
     */
    public $currency;

    /**
     * @return array
     */
    public function getCurrencyCodesAttribute(): array
    {
        return $this->currency ? explode(',', $this->currency) : [];
    }

    /**
     * @Assert\Length(min="1", max="250")
     * @var string
     */
    public $language;

    /**
     * @return array
     */
    public function getLanguagesAttribute(): array
    {
        return $this->language ? explode(',', $this->language) : [];
    }
}