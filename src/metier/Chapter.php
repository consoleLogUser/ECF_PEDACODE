<?php
declare(strict_types=1);

namespace pedacode\metier;

class Chapter {
    
    public function __construct(
        private string $title,
        private int $id_cat
    ) {
    }

    public function setTitle(string $newtitle) : void {
        $this->title = $newtitle;
    }
    
    
    public function getTitle() : string {
        return $this->title;
    }
    
    public function getId() : int {
        return $this->id_cat;
    }
}
