<?php


namespace App\Common\Entity;

class AbstractEntity implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}