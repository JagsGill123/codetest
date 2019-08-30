<?php


namespace App\Common\Entity\Traits;

/**
 * Trait HasIdTrait
 * @package App\Common\Entity\Traits
 */
trait HasIdTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}