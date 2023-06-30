<?php

class ArticleManager {
    private $articles;
    public function __construct() {
        $this->articles = file_get_contents("https://webik.ms.mff.cuni.cz/~34179985/cms/article-management/articles_get.php");
    }

    public function handleRequest() {
        $this->renderTop();
        $this->renderTable();
        $this->renderButtons();
        $this->renderDialog();
        $this->renderScripts();
    }

    private function renderTop(){
        ?>
        <table id="top-three-table">
            
        </table>
        <?php
    }

    private function renderTable() {
        ?>
        <table id="info-table">
            <tr id="article-header">
                <td><h4 id="article-head">Article list</h4></td>
                <td><h4 id="counter"></h4></td>
            </tr>
        </table>
        
        <table id="edit-form-table">

        </table>
        <?php
    }

    private function renderButtons() {
        ?>
        <table class="buttons">
            <tr>
                <td><button id="prev-button">Previous</button></td>
                <td><button id="create-button">Create article</button></td>
                <td><button id="next-button">Next</button></td>
            </tr>
        </table>
        <?php
    }

    private function renderDialog() {
        ?>
        <dialog id="create-dialog" style="display: none;">
            <form id="create-form">
                <table id="article-table">
                    <tr>
                        <td><label for="article-name">Name: </label></td>
                        <td><input type="text" id="article-name" maxlength="32" placeholder="Article name"required/></td>
                    </tr>
                    <tr>
                        <td><button type="button" id="create-cancel">Cancel</button></td>
                        <td><button type="submit" id="create-submit" disabled>Create</button></td>
                    </tr>
                </table>
            </form>
        </dialog>
        <?php
    }

    private function renderScripts() {
        ?>
        <script>
            var obj = JSON.parse('<?php echo str_replace(array("\r", "\n"), '', $this->articles); ?>');
        </script>
        <script type="text/javascript" src="./controllers/table_controller.js"></script>
        <script type="text/javascript" src="./controllers/control.js"></script>
        <?php
    }
}
$articleManager = new ArticleManager();
$articleManager->handleRequest();