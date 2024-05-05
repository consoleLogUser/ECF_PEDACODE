<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use pedacode\metier\Chapter;
use pedacode\metier\Category;

class ChapterTest extends TestCase
{
    private Chapter $chapter;
    private Category $category;

    protected function setUp(): void
    {
        $this->category = new Category("HTML", 1);
        $this->chapter = new Chapter(1, "Introduction HTML", $this->category);
    }

    public function testGetId()
    {
        $this->assertEquals(1, $this->chapter->getId());
    }

    public function testSetId()
    {
        $this->chapter->setId(2);
        $this->assertEquals(2, $this->chapter->getId());
    }

    public function testGetTitle()
    {
        $this->assertEquals("Introduction HTML", $this->chapter->getTitle());
    }

    public function testSetTitle()
    {
        $this->chapter->setTitle("Chapitre avancé");
        $this->assertEquals("Chapitre avancé", $this->chapter->getTitle());
    }

    public function testGetCategory()
    {
        $this->assertEquals($this->category, $this->chapter->getCategory());
    }

    public function testSetCategory()
    {
        $newCategory = new Category("CSS", 2);
        $this->chapter->setCategory($newCategory);
        $this->assertEquals($newCategory, $this->chapter->getCategory());
    }
}
