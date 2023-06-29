<?php
include "db_config.php";
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

$aId = $_GET["id"];

$query = "DELETE FROM articles WHERE id = $aId";
$result = mysqli_query($mysqli, $query);

$mysqli->close();
?>