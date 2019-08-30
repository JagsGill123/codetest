<?php

namespace App\Common\Entity\Traits;

/**
 * Trait HasFlagTrait
 * @package App\Common\Entity\Traits
 */
trait HasFlagTrait
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $flag;

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(?string $flag): self
    {
        $this->flag = $flag;

        return $this;
    }
}