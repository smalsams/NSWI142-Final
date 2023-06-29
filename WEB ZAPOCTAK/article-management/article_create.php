<?php
include "db_config.php";
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$aId = intval(time());

$query = "INSERT INTO articles VALUES ('$name', '', $aId)";
$result = mysqli_query($mysqli, $query);

$mysqli->close();

echo json_encode(['id' => $aId]);
?>