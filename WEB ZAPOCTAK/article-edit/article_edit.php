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
        if (isset($_POST["save"])) {
            $this->updateArticle($id, $_POST["article-name"], $_POST["article-content"]);
            header("Location: ../articles");
        }
        $this->fetchArticle($id);
        $this->mysqli->close();
        $this->renderForm();
    }

    private function updateArticle($id, $name, $content) {
      $query_handler = $this->mysqli->prepare("UPDATE articles SET name = ?, content = ? WHERE id = ?");
      $query_handler->bind_param("ssi", $name, $content, $id);
      $query_handler->execute();
  }

  private function fetchArticle($id) {
    $query_handler = $this->mysqli->prepare("SELECT * FROM articles WHERE id = ?");
    $query_handler->bind_param("i", $id);
    $query_handler->execute();
    $result = $query_handler->get_result();
    $this->article = $result->fetch_assoc();
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
            <td><textarea id="article-body" name="article-content" required maxlength="1024" rows="20" cols="100"><?php echo $this->article['content']; ?></textarea></td>
          </tr>
        </table>
        <table id="edit-form-table">
          <tr id="edit-buttons">
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