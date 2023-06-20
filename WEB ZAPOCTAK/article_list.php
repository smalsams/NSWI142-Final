<table id="info_table">
    <tr id="a_header">
        <td?><h4 id="article_head">Article list</h4></td>
        <td><h4 id="counter"></h4></td>
    </tr>
</table>
<table id="buttons">
  <tr>
    <td><button id="prev_button">Previous</button></td>
    <td><button id="next_button">Next</button></td>
    <td><button id="create_article_button">Create article</button></td>
  </tr>
</table>
<dialog id="create_article_dialog" style="display: none;">
  <form id="create_article_form">
      <table id="article_table">
        <tr>
          <td><label for="article_name">Name: </label></td>
          <td><input type="text" id="article_name" maxlength="32" placeholder="Article name"required/></td>
        </tr>
        <tr>
          <td><button type="button" id="create_article_cancel">Cancel</button></td>
          <td><button type="submit" id="create_article_submit" disabled>Create</button></td>
        </tr>
      </table>
  </form>
</dialog>

<?php
$vars = file_get_contents("https://webik.ms.mff.cuni.cz/~34179985/cms/articles_get.php");
?>

<script>
    var json = JSON.parse("<?= $content ?>".replace(/[\r\n]/g));
</script>

<script type="text/javascript" src="controllers/table_c.js"></script>

<script type="text/javascript" src="controllers/control.js"></script>