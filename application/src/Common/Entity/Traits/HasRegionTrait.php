<?php


namespace App\Common\Entity\Traits;

/**
 * Trait HasRegionTrait
 * @package App\Common\Entity\Traits
 */
trait HasRegionTrait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $region;

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }
}