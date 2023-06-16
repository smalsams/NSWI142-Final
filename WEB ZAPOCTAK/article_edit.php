<?php

require("db_config.php");
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

$id = $_GET['id'];
$query_result = mysqli_query($mysqli, "SELECT * FROM articles WHERE id = '$id'");

if (mysqli_num_rows($query_result) == 0) {
  http_response_code(404);
  exit();
}

$article = mysqli_fetch_assoc($query_result);
$mysqli->close();

?>
<form action="article-edit-submit.php" method="post">
  <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
  <div>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $article['name']; ?>" maxlength="32">
  </div>
  <div>
    <label for="content">Content:</label>
    <textarea id="content" name="content" maxlength="1024"><?php echo $article['content']; ?></textarea>
  </div>
  <div>
    <input type="submit" value="Save">
    <a href="./articles">Back to articles</a>
  </div>
</form>
<?php
$JSON = file_get_contents("articles_get.php");
$articles = json_decode($JSON, true);

foreach ($articles as &$a) {
  if ($a['id'] == $_POST['id']) {
    $a['name'] = $_POST['name'];
    $a['content'] = $_POST['content'];
    break;
  }
}

file_put_contents("articles_get.php", json_encode($articles));

header("Location: ../articles");