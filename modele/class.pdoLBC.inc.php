<?php

class Pdolbc
{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=lbc';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
		private static $monPdo;
		private static $monPdolbc = null;
			
	private function __construct()
	{
    		Pdolbc::$monPdo = new PDO(Pdolbc::$serveur.';'.Pdolbc::$bdd, Pdolbc::$user, Pdolbc::$mdp); 
			Pdolbc::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		Pdolbc::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 *
 
 * Appel : $instancePdolbc = Pdolbc::getPdolbcNat();
 * @return l'unique objet de la classe PdolbcNat
 */
	public  static function getPdolbc()
	{
		if(Pdolbc::$monPdolbc == null)
		{
			Pdolbc::$monPdolbc= new Pdolbc();
		}
		return Pdolbc::$monPdolbc;  
	}
/**
 * Retourne tous les clients sous forme d'un tableau associatif
 *
 * @return le tableau associatif des clients
*/
	public function getProfilConnexion($login, $mdp)
	{
		$req = 'SELECT *
		FROM profil
		WHERE profil.login = :login AND profil.mdp = :mdp';
		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue(":login", $login);
		$res->bindValue(":mdp", $mdp);
		$res->execute();
		return $res->fetch();
	}
	public function getSpecialites() {
		$req = "SELECT * FROM specialite";
		$res = Pdolbc::$monPdo->prepare($req);
		$res->execute();
		return $res->fetchAll();
	}
	public function getLesPraticiens()
	{
		$req = "select * from praticien";
		$res = Pdolbc::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function getLePraticien($idPraticien, $idSpecialite)
	{
		$req = "select * from praticien WHERE idSpecialite = :idSpecialite AND idPraticien = :idPraticien";
		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue(':idPraticien', $idPraticien);
		$res->bindValue(':idSpecialite', $idSpecialite);
		$res->execute();
		$lesLignes = $res->fetch();
		return $lesLignes;
	}

	/* Affiche le portefeuille du Responsabele */

	public function getPorteFeuilleRes() {
		$req = "select visiteur.matricule, nom, reg_code
		from portefeuille
		inner join praticien
		on praticien.idpraticien = portefeuille.idpraticien
		inner join visiteur
		on visiteur.matricule = portefeuille.matricule
		inner join region
		on region.sec_num = visiteur.sec_num";
		$res = Pdolbc::$monPdo->prepare($req);
		$res->execute();
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	/* Modifier le porte feuille */

	public function getmodifPortefeuille($matricule, $idspecialite, $idPraticien, $num,  $nvmatricule, $nvidspecialite,  $nvidpraticien){
		$req=("UPDATE portefeuille SET matricule = :matricule, idspecialite= :idspecialite, idpraticien = :idpraticien 
		where matricule = :nvmatricule, idspecialite= :nvidspecialite, idpraticien = :nvidpraticien");
		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue('matricule',$matricule, PDO::PARAM_STR);
		$res->bindValue('idspecialite', $idspecialite, PDO::PARAM_STR);   
		$res->bindValue('idpraticien', $idPraticien, PDO::PARAM_STR);
		$res->bindValue('nvmatricule', $nvmatricule, PDO::PARAM_STR);
		$res->bindValue('nvidspecialite', $nvidspecialite, PDO::PARAM_STR);
		$res->bindValue('nvidpraticien', $nvidpraticien, PDO::PARAM_STR);
		$res->execute();
	}

	/* Supprimer le portefeuille */

	public function getsuprrPortefeuille(){
		$req=('DELETE ');
	}

	/* Affiche le portefeuille lié au visiteur*/	

	public function getPorteFeuilleVis() {
		$req = "select * from portefeuille";
	
		$res = Pdolbc::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	/* praticien par visiteur */

	public function getPraticiensV($id)
	{
		$req = "select idPraticien from portefeuille";
		$res = Pdolbc::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	/* visiteur par praticien */

	public function getVisiteurP($id)
	{
		$req = "select matricule from portefeuille ";
		$res = Pdolbc::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function modifierPraticien($nom,$prenom,$specialite,$notoriete,$ville,$num)
	{
		$res = Pdolbc::$monPdo->prepare('UPDATE praticien 
			SET  nom = :nom, prenom = :prenom, idspecialite = :specialite, note = :notoriete, ville = :ville 
 			WHERE idPraticien = :num');
		
		$res->bindValue('nom',$nom, PDO::PARAM_STR);
		$res->bindValue('prenom', $prenom, PDO::PARAM_STR);   
		$res->bindValue('specialite', $specialite, PDO::PARAM_STR);
		$res->bindValue('notoriete', $notoriete, PDO::PARAM_INT);
		$res->bindValue('ville', $ville, PDO::PARAM_STR);
		$res->bindValue('num',$num, PDO::PARAM_INT);
		$res->execute();
		//print_r($res->errorInfo());
	}

	public function getMaxPraticienIndexParSpe($specialite)
	{
		$req = "SELECT MAX(idPraticien) as max FROM praticien WHERE idspecialite = :specialite";
		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue('specialite', $specialite);
		$res->execute();
		return $res->fetch();
	}

	public function ajouterPraticien($idSpecialite, $idPraticien, $note, $nom, $prenom, $rue, $codePostal, $ville, $longitude, $latitude)
	{
		$req = "INSERT INTO `praticien` (`idspecialite`, `idPraticien`, `note`, `nom`, `prenom`, `rue`, `codePostal`, `ville`, `longitude`, `latitude`) 
		VALUES (:idspecialite, :idPraticien, :note, :nom, :prenom, :rue, :codePostal, :ville, :longitude, :latitude)";
		$res = Pdolbc::$monPdo->prepare($req);

		var_dump($idSpecialite);
		var_dump($idPraticien);

		$res->bindValue(':idspecialite', $idSpecialite, PDO::PARAM_INT);
		$res->bindValue(':idPraticien', $idPraticien, PDO::PARAM_INT);
		$res->bindValue(':note', $note);
		$res->bindValue(':nom', $nom);
		$res->bindValue(':prenom', $prenom);
		$res->bindValue(':rue', $rue);
		$res->bindValue(':codePostal', $codePostal);
		$res->bindValue(':ville', $ville);
		$res->bindValue(':longitude', $longitude);
		$res->bindValue(':latitude', $latitude);
		$res->execute();
		
		var_dump($res->ErrorInfo());
	}



	public function getPraticiens($numVisiteur,$numSecteur) {
		$req = "SELECT praticien.idPraticien,praticien.nom,praticien.prenom,praticien.idspecialite,	praticien.note,praticien.ville,visite.dateVisite,visite.matricule,visiteur.sec_num
		from praticien
		inner join visite on praticien.idPraticien = visite.idPraticien 
		inner join visiteur on visite.matricule = visiteur.matricule 
		where visite.dateVisite = 
	(SELECT p2.dateVisite FROM visite p2
	 where praticien.idPraticien = p2.idpraticien and p2.dateVisite < now()  
			GROUP by p2.dateVisite DESC LIMIT 1)
		and visite.matricule =:numVisiteur and visiteur.sec_num=:numSecteur
		group by visite.idPraticien";
		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue(':numVisiteur', $numVisiteur);
		$res->bindValue(':numSecteur', $numSecteur);
		$res->execute();
		
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function getVisiteur($numPraticien,$numSecteur) {
		$req = "SELECT visiteur.matricule,visite.dateVisite,visiteur.sec_num
		from visiteur
		inner join visite on visiteur.matricule = visite.matricule 
		inner join praticien on visite.idPraticien = praticien.idPraticien
		where visite.dateVisite = (SELECT p2.dateVisite FROM visite p2
		where visiteur.matricule = p2.matricule and p2.dateVisite < now()
		ORDER by p2.dateVisite DESC
	    LIMIT 1)
		and visite.idPraticien =:numPraticien and visiteur.sec_num=:numSecteur";

		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue(':numPraticien', $numPraticien);
		$res->bindValue(':numSecteur', $numSecteur);
		$res->execute();

		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function getLesVisiteur()
	{
		$req = "select * from visiteur";
		$res = Pdolbc::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}	

	public function getLesRegion()
	{
		$req = "select * from region";
		$res = Pdolbc::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function getIdMaxSpecialite()
	{
		$req = "select MAX(idSpecialite) as max from specialite";
		$res = Pdolbc::$monPdo->query($req);
		$lignes = $res->fetch();
		return $lignes["max"];
	}

	public function ajouterSpecialite($nomSpecialite)
	{
		$idSpecialite = intval($this->getIdMaxSpecialite()) +1;
		$req = "INSERT INTO `specialite` (`idspecialite`, `nomspecialite`) VALUES (:idspecialite, :nomspecialite)";
		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue(':idspecialite', $idSpecialite);
		$res->bindValue(':nomspecialite', $nomSpecialite);
		$res->execute();
	}

	public function supprimerSpecialite($idSpecialite)
	{
		$req = "DELETE FROM `specialite` WHERE `specialite`.`idspecialite` = :idSpecialite";
		$res = Pdolbc::$monPdo->prepare($req);
		$res->bindValue(':idspecialite', $idSpecialite);
		$res->execute();
	}
}

?>