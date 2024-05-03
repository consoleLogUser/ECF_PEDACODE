<?php

declare(strict_types=1);

namespace pedacode\metier;

class Goal
{
    public function __construct(
        private int $id_goal,
        private string $descr_goal,
        private string $condi_goal,
        private Lesson $lesson
    ) {
    }

    public function getIdGoal(): int
    {
        return $this->id_goal;
    }

    public function getDescrGoal(): string
    {
        return $this->descr_goal;
    }

    public function setDescrGoal(string $descr_goal): void
    {
        $this->descr_goal = $descr_goal;
    }

    public function getCondiGoal(): string
    {
        return $this->condi_goal;
    }

    public function setCondiGoal(string $condi_goal): void
    {
        $this->condi_goal = $condi_goal;
    }

    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    public function setLesson(Lesson $lesson): void 
    {
        $this->lesson = $lesson;
    }
}

?>

