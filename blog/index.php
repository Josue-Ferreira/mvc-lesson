<?php

require_once('src/controllers/add_comment.php');
require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once('src/controllers/modify_comment.php');

use Application\Controllers\AddComment\AddComment;
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Post;
use Application\Controllers\ModifyComment\ModifyComment;

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                (new Post())->execute($identifier);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                (new AddComment())->execute($identifier, $_POST);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] === 'modifyComment') {
            if(isset($_GET['id']) && $_GET['id']>0) {
                (new ModifyComment())->execute($_GET['id'], $_GET['comment_id'], $_POST);
            }
        } elseif ($_GET['action'] === 'modifyCommentPage') {
            if(isset($_GET['id']) && $_GET['id']>0) {
               (new ModifyComment())->modifyCommentPage($_GET['id'],$_GET['comment_id']);
            }
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');
}
