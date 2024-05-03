<?php
declare(strict_types=1);
namespace pedacode\metier;

use pedacode\metier\Workspace;
use pedacode\metier\DataCode;


class WorkspacePlayground extends Workspace {
    private string      $name;
    private int         $slotIndex;

    public function __construct(int $id, ?DataCode $dataCode, string $dateCrea, string $dateModif, string $name, int $slotIndex) {
        parent::__construct($id, $dataCode, $dateCrea, $dateModif);

        $this->setName($name);
        $this->setSlotIndex($slotIndex);
    }

    public function setName(string $newName): void {
        $this->name = \htmlspecialchars(\substr($newName, 0, 20)); // TODO : si name length = 0 mettre la date de modif
    }
    public function setSlotIndex(int $newSlotIndex): void {
        $this->slotIndex = $newSlotIndex; // TODO : limiter à 8
    }

    public function getName(): string { return $this->name; }
    public function getSlotIndex(): int { return $this->slotIndex; }

    public function __toString(): string {
        return '[' . self::class
            . ': name=' . $this->name
            . ', slotIndex=' . $this->slotIndex
            . ', parent=' . $this
            . ']';
    }
}