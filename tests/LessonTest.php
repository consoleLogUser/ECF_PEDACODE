<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use pedacode\metier\Lesson;
use pedacode\metier\Chapter;
use pedacode\metier\Category;


class LessonTest extends TestCase
{
    private Lesson $lesson;
    private Chapter $chapter;

    protected function setUp(): void
    {
        $this->chapter = new Chapter(1, "Introduction à PHP", new Category("PHP", 1));
        $this->lesson = new Lesson(1, $this->chapter, null, "Variables en PHP", "Introduction aux variables");
    }

    public function testGetIdLes()
    {
        $this->assertEquals(1, $this->lesson->getIdLes());
    }

    public function testSetIdLes()
    {
        $this->lesson->setIdLes(2);
        $this->assertEquals(2, $this->lesson->getIdLes());
    }

    public function testGetChapter()
    {
        $this->assertEquals($this->chapter, $this->lesson->getChapter());
    }

    public function testSetChapter()
    {
        $newChapter = new Chapter(2, "Conditions en PHP", new Category("PHP", 1));
        $this->lesson->setChapter($newChapter);
        $this->assertEquals($newChapter, $this->lesson->getChapter());
    }

    public function testGetTitleLes()
    {
        $this->assertEquals("Variables en PHP", $this->lesson->getTitleLes());
    }

    public function testSetTitleLes()
    {
        $this->lesson->setTitleLes("Boucles en PHP");
        $this->assertEquals("Boucles en PHP", $this->lesson->getTitleLes());
    }

    public function testGetInstrLes()
    {
        $this->assertEquals("Introduction aux variables", $this->lesson->getInstrLes());
    }

    public function testSetInstrLes()
    {
        $this->lesson->setInstrLes("Introduction aux boucles");
        $this->assertEquals("Introduction aux boucles", $this->lesson->getInstrLes());
    }

    
}
