<?php
include "../db_config.php";
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

$aId = $_GET["id"];

$query_handler = $mysqli->prepare("DELETE FROM articles WHERE id = ?");
$query_handler->bind_param("i", $aId);
$query_handler->execute();


$mysqli->close();
?>