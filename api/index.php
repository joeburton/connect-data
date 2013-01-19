<?php

require 'Slim/Slim.php';

$app = new Slim();

$app->get('/contacts', 'getWines');
$app->get('/contacts/:id',	'getWine');
$app->get('/contacts/search/:query', 'findByName');
$app->post('/contacts', 'addWine');
$app->put('/contacts/:id', 'updateWine');
$app->delete('/contacts/:id',	'deleteWine');

$app->run();

function getWines() {
	$sql = "select * FROM mycontacts ORDER BY firstname";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$contacts = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		// echo '{"wine": ' . json_encode($contacts) . '}';
		echo json_encode($contacts);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getWine($id) {
	$sql = "SELECT * FROM mycontacts WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$contacts = $stmt->fetchObject();  
		$db = null;
		echo json_encode($contacts); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function addWine() {
	//error_log('addWine\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$contacts = json_decode($request->getBody());
	$sql = "INSERT INTO mycontacts (firstname, surname, mobile, email, dob, picture) VALUES (:firstname, :surname, :mobile, :email, :dob, :picture)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("firstname", $contacts->firstname);
		$stmt->bindParam("surname", $contacts->surname);
		$stmt->bindParam("mobile", $contacts->mobile);
		$stmt->bindParam("email", $contacts->email);
		$stmt->bindParam("dob", $contacts->dob);
		$stmt->bindParam("picture", $contacts->picture);
		$stmt->execute();
		$contacts->id = $db->lastInsertId();
		$db = null;
		echo json_encode($contacts); 
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateWine($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$contacts = json_decode($body);
	$sql = "UPDATE mycontacts SET firstname=:firstname, surname=:surname, mobile=:mobile, email=:email, dob=:dob, picture=:picture WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("firstname", $contacts->firstname);
		$stmt->bindParam("surname", $contacts->surname);
		$stmt->bindParam("mobile", $contacts->mobile);
		$stmt->bindParam("email", $contacts->email);
		$stmt->bindParam("dob", $contacts->dob);
		$stmt->bindParam("picture", $contacts->picture);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($contacts); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteWine($id) {
	$sql = "DELETE FROM mycontacts WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

/*
function findByName($query) {
	$sql = "SELECT * FROM mycontacts WHERE UPPER(name) LIKE :query ORDER BY name";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$contacts = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"wine": ' . json_encode($contacts) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
*/

function getConnection() {
	$dbhost="127.0.0.1";
	$dbuser="root";
	$dbpass="";
	$dbname="dev";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

/*

function getConnection() {
	$dbhost="213.171.219.98";
	$dbuser="joeburton1979";
	$dbpass="joeburton1979";
	$dbname="joeburton";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

*/

?>