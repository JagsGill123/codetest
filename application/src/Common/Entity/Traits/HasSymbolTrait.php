<?php


namespace App\Common\Entity\Traits;

/**
 * Trait HasSymbolTrait
 * @package App\Common\Entity\Traits
 */
trait HasSymbolTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $symbol;

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }
}