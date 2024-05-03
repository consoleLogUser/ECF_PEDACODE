<?php
declare(strict_types=1);
require_once('C:\wamp64\www\dm\vendor\autoload.php');
require_once('C:\wamp64\www\dm\Pedacode\tests\Stagiaire.php');

use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes as att;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
// 3 etapes de test : Given When Then // Arrange Act Assert


class StagiaireV2Test extends TestCase {

    private ? Stagiaire $domi;

    // 1 fois 
    #[BeforeClass]
    public static function debutClasse() : void {
        echo "[BeforeClass] ";	   
    }
			
    #[att\Before]					
    public function debut() : void {
        $this->domi = new Stagiaire("Muller","Domi",26,"log1","",new \DateTime());
        echo "[Before] ";	 
    }

    #[att\After]								// apres chaque test 
    public function fin() : void {
        $this->domi = null;
        echo "[After] ";		 
    }
	
    #[att\AfterClass]							// 1 fois 
    public static function tearDownFinClasse() : void {
        
        echo "[AfterClass] ";	 
    }

    // Test1
    #[att\Test]	
    #[TestDox('!!! DM !!!  un test !!!')]
    public function testCalculPwParDefaut() : void {

        echo " - Je suis test1 - ";

        // WHEN on envoie le message à l'objet stagiaire : calculPw();
        $this->domi->calculPw();
        $expected="muller00";

        // THEN le pw est le nom en minuscule . la chaine
        $this->assertEquals($expected,$this->domi->getPw());
    }

    // Test 2 
    #[att\Test]
    public function testCalculPwString2() : void {
        
        echo " - Je suis test2 - ";

        // GIVEN
        // $this->domi = new metier\Stagiaire("Muller","Domi",26,"log1","",new \DateTime());
        $chaine = "Aa";

        $this->domi->calculPw($chaine);
        $expected="mullerAa";

        $this->assertEquals($expected,$this->domi->getPw());
    }
}
?>