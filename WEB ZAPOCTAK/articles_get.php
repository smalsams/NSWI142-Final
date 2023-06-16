<?php
include("db_config.php");
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);
$query_result = mysqli_query($mysqli, "SELECT * FROM articles");
$JSONcontent = json_encode(mysqli_fetch_all($query_result, MYSQLI_ASSOC));
$mysqli->close();
print($JSONcontent);