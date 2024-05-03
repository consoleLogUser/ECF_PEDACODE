<?php
declare(strict_types=1);

namespace pedacode\metier;

class Chapter {
    public function __construct(
        private int $id,
        private string $title,
        private Category $category
    ) {
    }

    public function setTitle(string $newTitle) : void {
        $this->title = $newTitle;
    }
    
    public function getTitle() : string {
        return $this->title;
    }
    
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $newId) : void {
        $this->id = $newId;
    }

    public function getCategory() : Category {
        return $this->category;
    }

    public function setCategory(Category $newCategory) : void {
        $this->category = $newCategory;
    }
}
