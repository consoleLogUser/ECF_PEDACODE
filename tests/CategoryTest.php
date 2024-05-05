<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use pedacode\metier\Category;

class CategoryTest extends TestCase
{
    private Category $category;

    protected function setUp(): void
    {
        $this->category = new Category("HTML", 1);
    }

    public function testGetName()
    {
        self::assertEquals("HTML", $this->category->getName());
    }

    public function testSetName()
    {
        $this->category->setName("CSS");
        self::assertEquals("CSS", $this->category->getName());
    }

    public function testGetId()
    {
        self::assertEquals(1, $this->category->getId());
    }

    public function testSetId()
    {
        $this->category->setId(2);
        self::assertEquals(2, $this->category->getId());
    }

    public function testToString()
    {
        self::assertEquals("[Category : 1 - HTML]" . PHP_EOL, $this->category->__toString());
    }
}
