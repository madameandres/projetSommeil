<?
function connect()
{
	$hostname = "localhost";
	$user = "root";
	$pwd = "";
	$database = "projetSante";

	try {
		$mysqlConnection = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $user, $pwd);
		$mysqlConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $error) {
		echo $error;
	}
	return $mysqlConnection;
}


function disconnect($mysqlConnection)
{
	$mysqlConnection = null;
}

function insertFamille($mysqlConnection, $nom)
{
	$sqlQuery =  "INSERT INTO `famille` (`nom`) VALUES (:nom);";

	$statment = $mysqlConnection->prepare($sqlQuery);
	return $statment->execute([
		'nom' => $nom
	]);
}

function seConnecter($mysqlConnection, $formulaire)
{
	$statment = $mysqlConnection->prepare("select * from utilisateur where email= :email and password= :password");
	$statment->execute([
		'email' => $formulaire["email"],
		'password' => $formulaire["password"]
	]);
	//$statment->debugDumpParams();
	$utilisateur = $statment->fetch();
	if ($utilisateur) {
		update_last_connection($mysqlConnection, $utilisateur["id"]);
		$_SESSION["id"] = $utilisateur["id"];
		$_SESSION["prenom"] = $utilisateur["prenom"];
		return true;
	}
	return false;
}

function update_last_connection($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("update utilisateur set date_derniere_connexion= now() where id=:id");
	$statment->execute([
		'id' => $id
	]);
}


function deleteFamille($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("DELETE FROM famille where id=:id");
	$statment->execute([
		'id' => $id
	]);
}

function deleteMembre($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("DELETE FROM utilisateur where id=:id");
	$statment->execute([
		'id' => $id
	]);
}

function deleteSommeil($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("DELETE FROM sommeil where id_sommeil=:id");
	$statment->execute([
		'id' => $id
	]);
}

function deleteCampagne($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("DELETE FROM campagne where id_campagne=:id");
	$statment->execute([
		'id' => $id
	]);
}

function getFamille($mysqlConnection, $nom)
{
	$statment = $mysqlConnection->prepare("select * from famille where nom= :nom");
	$statment->execute([
		'nom' => $nom
	]);
	//$statment->debugDumpParams();
	return $statment->fetch();
}

function getFamilleById($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("select * from famille where id= :id");
	$statment->execute([
		'id' => $id
	]);
	//$statment->debugDumpParams();
	return $statment->fetch();
}

function getCampagneById($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("select * from campagne where id_campagne= :id");
	$statment->execute([
		'id' => $id
	]);
	//$statment->debugDumpParams();
	return $statment->fetch();
}

function getMembres($mysqlConnection, $idFamille)
{
	$statment = $mysqlConnection->prepare("select utilisateur.id as id, nom, prenom, (YEAR(CURRENT_DATE)-YEAR(date_naissance)) - (RIGHT(CURRENT_DATE,5)<RIGHT(date_naissance,5)) AS age, genre.libelle as genrenom, role.libelle as rolenom 
	from utilisateur 
	inner join famille on utilisateur.id_famille = famille.id
	inner join role on role.id = utilisateur.role
	inner join genre on genre.id = utilisateur.genre
	 where famille.id= :id");
	$statment->execute([
		'id' => $idFamille
	]);
	//$statment->debugDumpParams();
	return $statment->fetchAll();
}

function getUtilisateur($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("select * from utilisateur where id= :id");
	$statment->execute([
		'id' => $id
	]);
	//$statment->debugDumpParams();
	return $statment->fetch();
}

function listeSommeil($mysqlConnection)
{
	$statment = $mysqlConnection->prepare("SELECT
	id_sommeil, jour,
	utilisateur.prenom,
	famille.nom,
	/*DATE_FORMAT(coucher, '%d/%m') AS date_coucher,
  DATE_FORMAT(coucher, '%Hh%i') AS heure_coucher,
  DATE_FORMAT(endormissement, '%Hh%i') AS heure_endormissement,
  DATE_FORMAT(lever, '%Hh%i') AS heure_lever,*/
  coucher, endormissement, lever,
  TIME_FORMAT(TIMEDIFF(lever, endormissement), '%kh%i') AS temps_sommeil,
	fatigue,
	activite.libelle AS activite, 
	sommeil.id_campagne
  FROM
	sommeil
	INNER JOIN utilisateur ON utilisateur.id = sommeil.id_utilisateur
	INNER JOIN famille ON famille.id = utilisateur.id_famille
	INNER JOIN activite ON activite.id = sommeil.activite
  ORDER BY
	id_campagne desc, id_sommeil desc;
  ");
	$statment->execute([]);
	//$statment->debugDumpParams();
	return $statment->fetchAll();
}

function quiquimanque($mysqlConnection)
{
	$statment = $mysqlConnection->prepare("SELECT
	id_sommeil, jour,
	utilisateur.id,
	utilisateur.prenom,
	famille.nom,
	/*DATE_FORMAT(coucher, '%d/%m') AS date_coucher,
  DATE_FORMAT(coucher, '%Hh%i') AS heure_coucher,
  DATE_FORMAT(endormissement, '%Hh%i') AS heure_endormissement,
  DATE_FORMAT(lever, '%Hh%i') AS heure_lever,*/
  coucher, endormissement, lever,
  TIME_FORMAT(TIMEDIFF(lever, endormissement), '%kh%i') AS temps_sommeil,
	fatigue,
	activite.libelle AS activite, 
	sommeil.id_campagne
  FROM
	utilisateur
	LEFT JOIN sommeil ON utilisateur.id = sommeil.id_utilisateur AND jour = 'Nuit ".noJour($mysqlConnection)."' 
	LEFT JOIN famille ON famille.id = utilisateur.id_famille
	LEFT JOIN activite ON activite.id = sommeil.activite 
  ORDER BY
	id_campagne desc, id_sommeil desc;
  ");
	$statment->execute([]);
	//$statment->debugDumpParams();
	return $statment->fetchAll();
}

function getSommeil($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("SELECT * FROM sommeil where id_sommeil=:id ");
	$statment->execute(["id" => $id]);
	//$statment->debugDumpParams();
	return $statment->fetch();
}

function insertMembre($mysqlConnection, $formulaire)
{
	$message = "";

	$famille = getFamille($mysqlConnection, $formulaire["famille"]);
	if (!$famille) {
		insertFamille($mysqlConnection, $formulaire["famille"]);
		$idfamille = $mysqlConnection->lastInsertId();
		$message .= "La famille " . $formulaire["famille"] . " a été créée<br/>";
	} else {
		$idfamille = $famille["id"];
	}

	$sqlQuery =  "INSERT INTO `utilisateur` ( `prenom`, `email`, `password`, `role`, `date_naissance`,
	 `genre`, `id_famille`, `internat`) VALUES
	  (:prenom, :email, :password, :role, :date_naissance, :genre,  :id_famille, :internat);";

	$statment = $mysqlConnection->prepare($sqlQuery);
	try {
		$membre = $statment->execute([
			'prenom' => $formulaire["username"],
			'email' => $formulaire["email"],
			'password' => $formulaire["password"],
			'role' => $formulaire["role"],
			'date_naissance' => $formulaire["datenaissance"],
			'genre' => $formulaire["genre"],
			'id_famille' => $idfamille,
			'internat' => $formulaire["internat"]
		]);
		$statment->debugDumpParams();
	} catch (PDOException $e) {
		return $message .= "Erreur lors de la création du membre de la famille" . ($e->getCode() == 23000) ? "Cet email existe déjà " : "Erreur " . $e->getCode() . "<br/>";
	}
	return  $message .= $formulaire["username"] . " a été créé<br/>";
}

function updateMembre($mysqlConnection, $formulaire)
{
	$message = "";

	$sqlQuery =  "UPDATE `utilisateur` SET prenom= :prenom, email =  :email, `password`=:password, role= :role,
	 date_naissance=:date_naissance,genre= :genre, id_famille = :id_famille, internat =:internat, admin= :admin
	  WHERE id = :id";

	$statment = $mysqlConnection->prepare($sqlQuery);
	try {
		$statment->execute([
			'prenom' => $formulaire["username"],
			'email' => $formulaire["email"],
			'password' => $formulaire["password"],
			'role' => $formulaire["role"],
			'date_naissance' => $formulaire["datenaissance"],
			'genre' => $formulaire["genre"],
			'id_famille' => $formulaire["famille"],
			'internat' => $formulaire["internat"],
			'admin' => $formulaire["admin"],
			'id' => $formulaire["id"]
		]);
		//$statment->debugDumpParams();
	} catch (PDOException $e) {
		return $message .= "Erreur lors de la modification du membre de la famille " . $e->getMessage();
	}
	return  true;
}

function updateFamille($mysqlConnection, $formulaire)
{
	$message = "";

	$sqlQuery =  "UPDATE `famille` SET nom= :nom WHERE id = :id";

	$statment = $mysqlConnection->prepare($sqlQuery);
	try {
		$statment->execute([
			'nom' => $formulaire["nom"],
			'id' => $formulaire["id"]
		]);
		//$statment->debugDumpParams();
	} catch (PDOException $e) {
		return $message .= "Erreur lors de la modification du nom de la famille " . $e->getMessage();
	}
	return true;
}

function updateCampagne($mysqlConnection, $formulaire)
{
	$message = "";

	if ($formulaire["id_campagne"] == "") {
		$sqlQuery =  "INSERT INTO `campagne` (date_debut, date_fin) VALUES ( :date_debut, :date_fin);";
		$statment = $mysqlConnection->prepare($sqlQuery);
		try {
			$statment->execute([
				'date_debut' => $formulaire["date_debut"],
				'date_fin' => $formulaire["date_fin"]
			]);
		} catch (PDOException $e) {
			return $message .= "Erreur lors de la modification de la campagne " . $e->getMessage();
		}
		return true;
	} else {
		$sqlQuery =  "UPDATE `campagne` SET date_debut= :date_debut, date_fin=:date_fin WHERE id_campagne = :id_campagne";
		$statment = $mysqlConnection->prepare($sqlQuery);
		try {
			$statment->execute([
				'date_debut' => $formulaire["date_debut"],
				'date_fin' => $formulaire["date_fin"],
				'id_campagne' => $formulaire["id_campagne"]
			]);
		} catch (PDOException $e) {
			return $message .= "Erreur lors de la modification de la campagne " . $e->getMessage();
		}
		return true;
	}
}

function updateSommeil($mysqlConnection, $formulaire)
{
	$message = "";
	$sqlQuery =  "UPDATE `sommeil` SET id_utilisateur= :id_utilisateur,
	coucher=:coucher, endormissement=:endormissement, lever=:lever, fatigue=:fatigue,
	activite=:activite, jour=:jour, id_campagne=:campagne WHERE id_sommeil = :id";

	$statment = $mysqlConnection->prepare($sqlQuery);
	try {
		$statment->execute([
			'id_utilisateur' => $formulaire["id_utilisateur"],
			'coucher' => $formulaire["coucher"],
			'endormissement' => $formulaire["endormi"],
			'lever' => $formulaire["lever"],
			'fatigue' => $formulaire["fatigue"],
			'activite' => $formulaire["activite"],
			'jour' => $formulaire["jour"],
			'campagne' => $formulaire["campagne"],
			'id' => $formulaire["id_sommeil"]
		]);
	} catch (PDOException $e) {
		$statment->debugDumpParams();
		exit();
		return $message .= "Erreur lors de la modification " . $e->getMessage();
	}
	return  true;
}

function insertsommeil($mysqlConnection, $formulaire)
{
	$message = "";

	$sqlQuery =  "INSERT INTO `sommeil` ( `id_utilisateur`,`jour`, `coucher`,
	`endormissement`, `lever`, `fatigue`, `activite`, `id_campagne`)
	VALUES (:id_utilisateur,:jour, :coucher, :endormissement,
	:lever, :fatigue, :activite, :campagne); ";

	$statment = $mysqlConnection->prepare($sqlQuery);
	try {
		$membre = $statment->execute([
			'id_utilisateur' => $formulaire["id"],
			'jour' => $formulaire["jour"],
			'coucher' => $formulaire["coucher"],
			'endormissement' => $formulaire["endormi"],
			'lever' => $formulaire["lever"],
			'fatigue' => $formulaire["fatigue"],
			'activite' => $formulaire["activite"],
			'campagne' => idCampagneActive($mysqlConnection)
		]);

		//$statment->debugDumpParams();
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return $message .= "Erreur lors de l'enregistrement du sommeil<br/>";
	}
	return  $message = true;
}

function calculSommeil($mysqlConnection, $id)
{
	$sqlQuery = "SELECT jour, TIME_FORMAT(SUM(TIMEDIFF(lever,endormissement)),'%H\h%i') as duree 
	FROM sommeil 
	INNER JOIN campagne ON campagne.id_campagne = sommeil.id_campagne
	WHERE id_utilisateur = :id_utilisateur 
	AND CURDATE() BETWEEN date_debut AND date_fin 
	GROUP BY jour  ";

	$statment = $mysqlConnection->prepare($sqlQuery);
	if ($statment->execute(['id_utilisateur' => $id])) {
		return $sommeil = $statment->fetchAll();
	}
}


function listeFamilles($mysqlConnection)
{
	$famille = null;

	$statment = $mysqlConnection->prepare("SELECT fa.id, fa.nom, count(*)as nbMembres from famille fa left join utilisateur ut on ut.id_famille = fa.id group by fa.id, fa.nom");
	if ($statment->execute()) {
		$famille = $statment->fetchAll();
	}
	return $famille;
}

function listeActivites($mysqlConnection)
{
	$activite = null;

	$statment = $mysqlConnection->prepare("SELECT * from activite");
	if ($statment->execute()) {
		$activite = $statment->fetchAll();
	}
	return $activite;
}


function listeGenres($mysqlConnection)
{
	$genres = null;

	$statment = $mysqlConnection->prepare("SELECT * from genre order by libelle");
	if ($statment->execute()) {
		$genres = $statment->fetchAll();
	}
	return $genres;
}

function listeRoles($mysqlConnection)
{
	$role = null;

	$statment = $mysqlConnection->prepare("SELECT * from role order by libelle");
	if ($statment->execute()) {
		$role = $statment->fetchAll();
	}
	return $role;
}

function listeUtilisateurs($mysqlConnection)
{
	$users = null;

	$statment = $mysqlConnection->prepare("SELECT utilisateur.id as id,email, nom, prenom, role.libelle as role, genre.libelle as genre, admin, internat, DATEDIFF(CURDATE(), date_naissance) / 365 as age 
	from utilisateur 
	inner join famille on famille.id = utilisateur.id_famille
	inner join genre on utilisateur.genre = genre.id
	inner join role on role.id=utilisateur.role
	order by nom, prenom");
	if ($statment->execute()) {
		//$statment->debugDumpParams();
		$users = $statment->fetchAll();
	}
	return $users;
}

function listeCampagnes($mysqlConnection)
{
	$campagne = null;

	$statment = $mysqlConnection->prepare("SELECT *, 
	CASE  WHEN CURDATE() BETWEEN date_debut AND date_fin THEN 'Oui' ELSE 'Non' END AS is_active  from campagne");
	if ($statment->execute()) {
		$campagne = $statment->fetchAll();
	}
	return $campagne;
}

function nbJours($mysqlConnection)
{
	$statment = $mysqlConnection->prepare("SELECT DATEDIFF(date_fin, date_debut)+1 AS nbJours
	FROM campagne
	WHERE CURDATE() BETWEEN date_debut AND date_fin ");
	$statment->execute();
	//$statment->debugDumpParams();
	return $statment->fetchColumn();
}

function noJour($mysqlConnection)
{
	$statment = $mysqlConnection->prepare("SELECT DATEDIFF(CURDATE(), date_debut)+1 AS jour_actuel
	FROM campagne
	WHERE CURDATE() BETWEEN date_debut AND date_fin");
	$statment->execute();
	//$statment->debugDumpParams();
	return $statment->fetchColumn();
}

function campagneActive($mysqlConnection)
{
	$statment = $mysqlConnection->prepare("SELECT count(*) as nbCampagneEnCours FROM campagne
	WHERE CURDATE() BETWEEN date_debut AND date_fin ");
	$statment->execute();
	return ($statment->fetchColumn() == 1) ? true : false;
}

function idCampagneActive($mysqlConnection)
{
	$statment = $mysqlConnection->prepare("SELECT id_campagne FROM campagne
	WHERE CURDATE() BETWEEN date_debut AND date_fin ");
	$statment->execute();
	return $statment->fetchColumn();
}

function accesAdmin($mysqlConnection, $id)
{
	$statment = $mysqlConnection->prepare("SELECT admin FROM utilisateur WHERE id=:id ");
	$statment->execute(["id"=>$id]);
	return $statment->fetchColumn();
}
