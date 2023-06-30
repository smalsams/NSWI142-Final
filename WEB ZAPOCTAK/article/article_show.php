<?php
include "db_config.php";

class ArticleViewer {
    private $mysqli;
    private $article;

    public function __construct($db_config) {
        $this->mysqli = mysqli_connect($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);
    }

    public function handleRequest() {
        $aId = $_GET["id"];
        if (isset($_POST["main-page-return"])) {
            header("Location: ../articles");
            return;
        }
        if (isset($_POST["edit-page"])){
            header("Location: ../article-edit/" . $aId);
            return;
        }

        $query_handler = $this->mysqli->prepare("UPDATE articles SET views=views+1 WHERE id = ?");
        $query_handler->bind_param("i", $aId);
        $query_handler->execute();
        $this->fetchArticle($aId);
        $this->renderArticle();
        $this->renderForm();
    }
    private function fetchArticle($id) {
        $query_handler = $this->mysqli->prepare("SELECT * FROM articles WHERE id = ?");
        $query_handler->bind_param("i", $id);
        $query_handler->execute();
        $result = $query_handler->get_result();
        $this->article = $result->fetch_assoc();
    }

    private function renderArticle() {
        ?>
        <table>
            <tr>
                <td><h3><?php echo htmlspecialchars($this->article["name"])?></h3></td>
            </tr>
            <tr><td><p>Number of views: <?php echo htmlspecialchars($this->article["views"])?></p></td></tr>
        </table>
        <p><?php echo htmlspecialchars($this->article["content"])?></p>
        <?php
    }

    private function renderForm() {
        ?>
        <form method="post">
            <table class="buttons">
                <td><input type="submit" name="edit-page" value="Edit"></td>
                <td><input type="submit" name="main-page-return" value="Back to the main page"></td>
            </table>
        </form>
        <?php
    }
}

$articleViewer = new ArticleViewer($db_config);
$articleViewer->handleRequest();