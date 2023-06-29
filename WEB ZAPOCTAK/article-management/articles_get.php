<?php
header("Content-Type: application/json");
include("../db_config.php");
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);
$query = "SELECT * FROM articles";
$query_result = mysqli_query($mysqli, $query);
$temp = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
$JSONcontent = json_encode($temp);
$mysqli->close();
print($JSONcontent);