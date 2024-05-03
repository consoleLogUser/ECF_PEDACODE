<?php

declare(strict_types=1);

namespace pedacode\metier;

class Langage implements \JsonSerializable
{


    public function __construct(
        private int $id,
        private string $name,
        private string $extension,
    ) {
    }

    public function setId(int $newId)
    {
        $this->id = $newId;
    }
    public function setName(string $newname)
    {
        $this->name = $newname;
    }
    public function setExtension(string $newExtension)
    {
        $this->extension = $newExtension;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getExtension(): string
    {
        return $this->extension;
    }

    public function __toString(): string
    {
        return
            '[' . self::class
            . ': id=' . $this->id
            . ', name=' . $this->name
            . ', extension=' . $this->extension
            . ']';
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'extension' => $this->extension
        ];
    }
}
