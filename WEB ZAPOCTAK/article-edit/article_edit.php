<?php
require("db_config.php");

class ArticleEditor {
    private $mysqli;
    private $article;

    public function __construct($db_config) {
        $this->mysqli = new mysqli($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);
    }

    public function handleRequest() {
        $id = $_GET["id"];
        if (isset($_POST['save'])) {
            $this->updateArticle($id, $_POST['article-name'], $_POST['article-content']);
            header("Location: ../articles");
        }
        $this->fetchArticle($id);
        $this->mysqli->close();
        $this->renderForm();
    }

    private function updateArticle($id, $name, $content) {
        $query = "UPDATE articles SET name = '$name', content = '$content' WHERE id = $id;";
        $this->mysqli->query($query);
    }

    private function fetchArticle($id) {
        $query_result = $this->mysqli->query("SELECT * FROM articles WHERE id =$id");
        $this->article = mysqli_fetch_assoc($query_result);
    }

    private function renderForm() {
      ?>

      <form method="POST" id="edit-form">
        <table>
          <tr>
            <td><label for="article-name">Name</label></td>
          </tr>
          <tr>
            <td><input type="text" name="article-name" id="article-name" required maxlength="32" value="<?php echo $this->article['name']; ?>"> </td>
          </tr>
          <tr>
            <td><label for="article-body">Content</label></td>
          </tr>
          <tr>
            <td><textarea id="article-body" name="article-content" required maxlength="1024"><?php echo $this->article['content']; ?></textarea></td>
          </tr>
        </table>
        <table id="table1">
          <tr>
            <td><input type="submit" name="save" value="Save"></td>
            <td><button type="button" id="main-page-return">Back to articles</button></td>
          </tr>
        </table>
      </form>
      <script>
            const mainReturn = document.getElementById("main-page-return");
            mainReturn.addEventListener("click", () => {window.location.href="../articles"});
        </script>
      <?php
    }
}

$articleEditor = new ArticleEditor($db_config);
$articleEditor->handleRequest();