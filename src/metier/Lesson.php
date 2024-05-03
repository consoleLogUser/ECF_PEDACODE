<?php

declare(strict_types=1);

namespace pedacode\metier;

class Lesson
{
    public function __construct(
        private int $id_les,
        private int $id_chap,
        private int $id_sub,
        private string $title_les,
        private string $instr_les,
        // private \DateTimeInterface $creation ,

    ) {
    }

    public function getIdLes(): int
    {
        return $this->id_les;
    }

    public function setIdLes($id_les): void
    {
        $this->id_les = $id_les;
    }

    public function getTitleLes(): string
    {
        return $this->title_les;
    }
    public function setTitleLes($title_les): void
    {
        $this->title_les = $title_les;
    }


    public function getIdChap(): int
    {
        return $this->id_chap;
    }

    // public function getCreationToString(): string
    // {
    //     return $this->creation->format('d/m/Y');;
    // }

    // public function setCreation(\DateTimeInterface $creation): void
    // {
    //     $this->creation = $creation;
    // }

    public function getIdSub(): int
    {
        return $this->id_sub;
    }

    public function setIdSub($id_sub): void
    {
        $this->id_sub = $id_sub;
    }

    public function getInstrLes(): string
    {
        return $this->instr_les;
    }

    public function setInstrLes($instr_les): void
    {
        $this->instr_les = $instr_les;
    }
}
