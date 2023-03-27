<?php
    $title='Modifier un commentaire';
    ob_start();
?>
<h1>Le super blog de l'AVBN !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>
<h2>Modifier le commentaire</h2>

<form action="index.php?action=modifyComment&id=<?= $post_id ?>&comment_id=<?= $comment_id ?>" method="post">
   <div>
      <label for="comment">Commentaire modifié</label><br />
      <textarea id="comment" name="comment"></textarea>
   </div>
   <div>
      <input type="submit" />
   </div>
</form>
<?php 
    $content = ob_get_clean(); 
    require('layout.php')
?>