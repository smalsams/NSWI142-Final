<?php
include "db_config.php";

class PageHandler {
    private $mysqli;
    private $page = "";
    private $error_flag = false;
    private $numbered = false;

    public function __construct($db_config) {
        $this->mysqli = mysqli_connect($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);
    }

    public function handleRequest() {
        if (isset($_GET['page'])) {
            $this->routePage($_GET['page']);
        } else {
            $this->sendError();
        }
        if($this->numbered){
            $this->queryArticle();
        }
        mysqli_close($this->mysqli);

        if(!$this->error_flag){
            $this->renderPage();
        }
    }

    private function routePage($page) {
        switch ($page) {
            case "article":
                if(!isset($_GET['id'])){
                    $this->sendError();
                }
                else{
                    $this->numbered = true;
                    $this->page = "./article/article_show.php";
                }
                break;
            case "article-edit":
                if(!isset($_GET['id'])){
                    $this->sendError();
                }
                else{
                    $this->numbered = true;
                    $this->page = "./article-edit/article_edit.php";
                }
                break;         
            case "articles":
                $this->page = "./article-list/article_list.php";
                break;
            default:
                $this->sendError();
        }
    }

    private function queryArticle() {
        $id = $_GET['id'];
        $queried_article = mysqli_fetch_assoc(
            mysqli_query(
                $this->mysqli, "SELECT * FROM articles WHERE id = $id"
            )
        );
        if(!$queried_article){
            $this->sendError();
        }
    }

    private function renderPage() {
        include "templates/header.php";
        include $this->page;
        include "templates/footer.php";
    }

    private function sendError() {
        $this->error_flag = true;
        http_response_code(404);
        exit;
    }
}

$pageHandler = new PageHandler($db_config);
$pageHandler->handleRequest();


