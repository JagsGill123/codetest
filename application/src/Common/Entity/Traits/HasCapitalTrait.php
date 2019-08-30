<?php


namespace App\Common\Entity\Traits;

/**
 * Trait HasCapitalTrait
 * @package App\Common\Entity\Traits
 */
trait HasCapitalTrait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $capital;

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(?string $capital): self
    {
        $this->capital = $capital;
        return $this;
    }
}