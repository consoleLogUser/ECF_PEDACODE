<?php

declare(strict_types=1);

namespace pedacode\metier;

use pedacode\metier\Workspace;
use pedacode\metier\DataCode;
use pedacode\metier\Lesson;

class WorkspaceLessRepo extends Workspace
{
    private Lesson $lesson;

    public function __construct(int $id_wk, ?DataCode $dataCode, string $dateCrea, string $dateModif, Lesson $lesson)
    {
        parent::__construct($id_wk, $dataCode, $dateCrea, $dateModif);
        $this->lesson = $lesson;
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

