<?php


namespace App\Common\Entity\Traits;

/**
 * Trait HasNameTrait
 * @package App\Common\Entity\Traits
 */
trait HasNameTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}