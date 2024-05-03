<?php
declare(strict_types=1);
namespace pedacode\metier;

use Pedacode\dao\DaoException;

class Category {
    public function __construct(
        private string $name,
        private int $id
        ) {
    }
    public function getName() : String { return $this->name; }
    public function setName($newName) : void { $this->name = $newName; }
    
    public function getId() : int { return $this->id; }
    public function setId($newId) : void { $this->id = $newId; }

    public function __toString() {
        $chaine =  '[Category : ' . $this->getId() . ' - ' . $this->getName() . ']' . PHP_EOL;
        return $chaine;
    }

}