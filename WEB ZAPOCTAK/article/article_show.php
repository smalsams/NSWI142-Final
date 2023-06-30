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
        }
        if (isset($_POST["edit-page"])){
            header("Location: ../article-edit/" . $aId);
        }
        $this->fetchArticle($aId);
        $this->renderArticle();
        $this->renderForm();
    }

    private function fetchArticle($id) {
        $query = "SELECT * FROM articles WHERE id = $id";
        $query_result = mysqli_query($this->mysqli, $query);
        $this->article = mysqli_fetch_assoc($query_result);
    }

    private function renderArticle() {
        ?>
        <table>
            <tr>
                <td rowspan="2"><h3><?php echo $this->article["name"] ?></h3></td>
            </tr>
        </table>
        <p><?php echo $this->article["content"] ?></p>
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