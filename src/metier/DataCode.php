<?php
declare(strict_types=1);
namespace pedacode\metier;

use pedacode\metier\Langage;

class DataCode implements \JsonSerializable {
    private int $id;
    private Langage $langage;
    private string $code;

    public function __construct(int $id, string $code, Langage $langage) {
        $this->setCode($code);
        $this->setId($id);
        $this->setLangage($langage);
    }

    public function setCode(string $newCode) {
        $this->code = $newCode; // TODO : protéger la bdd
    }
    public function setId(int $newId) { $this->id = $newId; }
    public function setLangage(Langage $newLangage) { $this->langage = $newLangage; }

    public function getCode(): string { return $this->code; }
    public function getId(): int { return $this->id; }
    public function getLangage(): Langage { return $this->langage; }

    public function  __toString() : string {
        return '[' . self::class
        . ': id=' . $this->id
        . ', langage=' . $this->langage
        . ', code=' . $this->code
        . ',]';
    }

    public function jsonSerialize(): mixed {
        return array(
            'id' => $this->id,
            'code' => $this->code,
            'langage' => $this->langage
        );
    }
}