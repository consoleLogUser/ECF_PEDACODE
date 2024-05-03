<?php
declare(strict_types=1);
require_once('C:\wamp64\www\dm\vendor\autoload.php');
require_once('C:\wamp64\www\dm\Pedacode\tests\Stagiaire.php');

use PHPUnit\Framework\TestCase;
// 3 etapes de test : Given When Then // Arrange Act Assert

class StagiaireTest extends TestCase {
    
    // Test 1 - calcul du mot de passe par default
    public function testCalculPwParDefaut() : void {

        // GIVEN un objet stagiaire existe
        // GIVEN son nom existe et a au moins un caractere
        // GIVEN la chaine du pw est donnee et contient 2 caracteres 
        $jean = new Stagiaire("Muller","Jean",26,"log1","",null);

        // WHEN on envoie le message à l'objet stagiaire : calculPw();
        $jean->calculPw();
        $expected="muller00";

        // THEN le pw est le nom en minuscule . la chaine
        $this->assertEquals($expected,$jean->getPw());
    }

    public function testCalculPwString2() : void {

        // GIVEN un objet stagiaire existe
        // GIVEN son nom existe et a au moins un caractere
        // GIVEN la chaine du pw est donnee et contient 2 caracteres 
        $domi = new Stagiaire("Muller","Domi",26,"log1","",new \DateTime());
        $chaine = "Aa";

        // WHEN on envoie le message à l'objet stagiaire : calculPw($chaine);
        $domi->calculPw($chaine);
        $expected="mullerAa";

        // THEN le pw est le nom en minuscule . la chaine
        $this->assertEquals($expected,$domi->getPw());
    }
}
?>