<?php

declare(strict_types=1);

namespace pedacode\metier;

class Lesson
{
    private array $goals = []; 
    public function __construct(
        private int $id_les,
        private Chapter $chapter,  
        private ?int $id_sub,
        private string $title_les,
        private ?string $instr_les
    ) {
    }

    public function getIdLes(): int
    {
        return $this->id_les;
    }

    public function setIdLes(int $id_les): void
    {
        $this->id_les = $id_les;
    }

    public function getChapter(): Chapter
    {
        return $this->chapter;
    }

    public function setChapter(Chapter $chapter): void
    {
        $this->chapter = $chapter;
    }

    public function getTitleLes(): string
    {
        return $this->title_les;
    }

    public function setTitleLes(string $title_les): void
    {
        $this->title_les = $title_les;
    }

    public function getIdSub(): int
    {
        return $this->id_sub;
    }

    public function setIdSub(int $id_sub): void
    {
        $this->id_sub = $id_sub;
    }

    public function getInstrLes(): ?string
    {
        return $this->instr_les;
    }

    public function setInstrLes(string $instr_les): void
    {
        $this->instr_les = $instr_les;
    }

    public function getGoals(): array
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): void
    {
        $this->goals[] = $goal;
    }
}
