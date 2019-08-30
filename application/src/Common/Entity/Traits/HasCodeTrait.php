<?php


namespace App\Common\Entity\Traits;

/**
 * Trait HasNameTrait
 * @package App\Common\Entity\Traits
 */
trait HasCodeTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}