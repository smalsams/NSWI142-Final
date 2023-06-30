<?php
include "../db_config.php";
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

$data = json_decode(file_get_contents("php://input"), true);
$name = $data["name"];
$aId = intval(time());

$query_handler = $mysqli->prepare("INSERT INTO articles VALUES (?, ?, '', 0)");
$query_handler->bind_param("is", $aId, $name);
$query_handler->execute();

$mysqli->close();

echo json_encode(["id" => $aId]);
