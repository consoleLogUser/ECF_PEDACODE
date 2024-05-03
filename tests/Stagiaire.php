<?php
declare(strict_types=1);


// TODO login unique

class Stagiaire {

	private ?String $nom;
	private ?String $prenom; 
	private ?int $age; 
	private ?String $login; 
	private ?String $pw; 
	private ?\DateTime $inscription;

	public function __construct (
		?String $nom 		= null, 
		?String $prenom 	= null, 
		?int $age 			= null, 
		?String $login 		= null, 
		?String $pw 		= null, 
		?\DateTime $inscription = null
		) {
	$this->setNom($nom);
	$this->setPrenom($prenom);
	$this->setAge($age);
	$this->setLogin($login);
	$this->setPw($pw);
	$this->setInscription($inscription);
	}

	// version 1 - non fonctionnelle !!! voir plus bas.
	/**
	 * Calcul du password à partir d'une chaine.
	 * Si la chaine est vide ou la longueur != 2, alors chaine = 00 
	 * @param  chaine la chaine ajoutee au nom en minuscule :  2 caracteres obligatoires
	 * @return le password
	 */
	public function calculPw(string $chaine='00') : string {
		// V1
		// $this->setPw($this->nom . $chaine);
		// V2 
		$this->setPw(strtolower($this->nom) . $chaine);
		return $this->getPw();
	}

	// version 2
	// renvoie le pw et maj du stagiaire
	// le nom doit etre renseigne et mini, 1 caractere
	// si pas de chaine en entree 						alors nom en minuscule + 00
	// sinon si la chaine est vide ou la longueur != 2  alors nom en minuscule + 00
	//       sinon 										nom en minuscule + chaine
	//  
	// public function calculPw(?string $chaine = null){
	// 	if ($this->getNom()!=null && strlen($this->getNom()) != 0) {
	// 		if (!isset($chaine) || strlen($chaine) <2) $chaine = "00";
	// 		$nom = strtolower($this->getNom());
	// 		$nom = str_replace(" ","",$nom);
	// 		$this->setPw($nom . $chaine);
	// 	}
	// 	return $this->getPw();
	// }

	// $s1->equals($s2) si $s1 et $s2 ont le meme nom
	public function equals(Stagiaire $stagiaire) {
		$reponse = false;
		if (strtolower($this->getNom()) === strtolower($stagiaire->getNom())) $reponse = true;
		return $reponse;
	}

	public function getNom(): ?String {
		return $this->nom;
	}
	public function setNom(?String $nom) {
		$this->nom = $nom;
	}

	public function getPrenom(): ?String {
		return $this->prenom;
	}
	public function setPrenom(?String $prenom) {
		$this->prenom = $prenom;
	}

	public function getAge(): ?int {
		return $this->age;
	}

	// Demande du CDC : entre 0 et 100, bornes incluses sinon erreur
	// ne correspond pas au CDC
	public function setAge(int $age) {
		if ($age < 0 || $age > 100) $age = 100;
		$this->age = $age;
	}
	// public function setAge(?int $age) {
	// 	if ($age == null || $age < 0 || $age > 100) throw new \Exception("L age est invalide", 999);
	// 	$this->age = $age;
	// }

	public function getLogin(): ?String {
		return $this->login;
	}
	public function setLogin(?String $login) {
		$this->login = $login;
	}

	public function getPw(): ?String {
		return $this->pw;
	}
	public function setPw(?String $pw) {
		$this->pw = $pw;
	}

	public function getInscription(): ?\DateTime {
		return $this->inscription;
	}
	public function setInscription(?\DateTime $inscription) {
		$this->inscription = $inscription;
	}

	//V1
	public function __toString() {
		return "["
		. $this->nom ."," . $this->prenom . "," . $this->age . "," . $this->login . "," . $this->pw	. "," 
		. (($this->inscription == null) ? "N/OOOHHH" : $this->inscription->format('d m Y')) 
		. "]";
	}
	// V2
	// public function __toString() {
	// 	return "["
	// 	. $this->nom ."," . $this->prenom . "," . $this->age . "," . $this->login . "," . $this->pw	. "," 
	// 	. (($this->inscription == null) ? "N/A" : $this->inscription->format('d m Y')) 
	// 	. "]";
	// }
}
?>