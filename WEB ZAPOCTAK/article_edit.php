<?php

require("db_config.php");
$mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

$id = $_GET['id'];
if (isset($_POST['save'])) {
  $article_name = $_POST['article_name'];
  $article_content = $_POST['article_content'];
  $query = "UPDATE articles SET name = '$article_name', content = '$article_content' WHERE id = $id;";
  $result = mysqli_query($connection, $query);  
  header("Location: ../articles");
}
$query_result = mysqli_query($mysqli, "SELECT * FROM articles WHERE id =$id");

$article = mysqli_fetch_assoc($query_result);
$mysqli->close();

?>
<form id="edit_form" method="POST">
  <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
  <div>
    <label for="name">Name:</label>
    <input type="text" id="article_name" name="article_name" value="<?php echo $article['name']; ?>" maxlength="32">
  </div>
  <div>
    <label for="content">Content</label>
    <textarea id="article_body" name="article_content" required maxlength="1024"><?php echo $article['content']; ?></textarea>
  </div>
  <div>
    <input type="submit" value="Save" name = "save">
    <button type="button" id="main_page_return">Back to articles</button>
  </div>
</form>
<script>
  const mainReturn = document.getElementById("main_page_return");
  backToIndex.addEventListener("click", () => {window.location.href="articles"});
</script>