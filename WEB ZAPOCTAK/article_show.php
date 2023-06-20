<?php

include "./db_config.php";
$mysqli = mysqli_connect($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

if (isset($_POST["main_page_return"])) {
    header("Location: ../articles");
}
$id = $_GET['id'];
if (isset($_POST["edit_page"])){
    header("Location: ../article-edit/" . $id);
}
$query_result = mysqli_query($mysqli, "SELECT * FROM articles WHERE id = $id");
$resulting_article = mysqli_fetch_assoc($query_result);

?>
<table>
    <tr>
        <td rowspan="2"><h3><?php echo $article["name"] ?></h3></td>
    </tr>
</table>
<p><?php echo $resulting_article["content"] ?></p>

<form method="post">
    <table id="pgs">
        <td><input type="submit" name="main_page_return" value="Back to the main page"></td>
        <td><input type="submit" name="edit_page" value="Edit"></td>
    </table>
</form>