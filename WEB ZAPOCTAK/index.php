<?php
$page = "";
$error_flag = false;
$numbered = false;
include "./db_config.php";
$mysqli = mysqli_connect($db_config["server"], $db_config["login"], $db_config["password"], $db_config["database"]);

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case "article":
            if(!isset($_GET['id'])){
                $error_flag = true;
                http_response_code(404);
                exit;
            }
            $id = $_GET['id'];
            $numbered = true;
            $page = "article_show.php";
            break;         
        case "article-edit":
            if(!isset($_GET['id'])){
                $error_flag = true;
                http_response_code(404);
                exit;
            }
            $page = "article_edit.php";
            break;
        case "articles":
            $page = "articles_list.php";
            break;
        default:
            $error_flag = true;
            http_response_code(404);
            exit;
    }
}
else {
    $error_flag = true;
    http_response_code(404);
    exit;
}
if($numbered) { 
    $queried_article = mysqli_fetch_assoc(
        mysqli_query(
            $mysqli, "SELECT * FROM articles WHERE id = $id"
        )
    );
    if(!$queried_article){
        $error_flag = true;
        http_response_code(404);
        exit;
    }
}
mysqli_close($mysqli);
if(!$error_flag){
    include "templates/header.php";
    include $page;
    include "templates/footer.php";
}

