<?php

namespace Application\Controllers\ModifyComment;

require_once('src/model/comment.php');
require_once('src/lib/database.php');

use Application\Model\Comment\CommentRepository;
use Application\Lib\Database\DatabaseConnection;

class ModifyComment {
    public function modifyCommentPage(string $post_id, string $comment_id) 
    {
        require('templates/modify_comment.php');
    }
    
    public function execute(string $post_id, string $comment_id, array $input)
    {
        if (!empty($input['comment']) && $comment_id > 0) {
            $modifiedcomment= $input['comment'];
        } else {
            throw new \Exception ('Données invalides');
        }
        
        $comment= new CommentRepository();
        $comment->connection = new DatabaseConnection();
        $succes= $comment->modifyComment($comment_id, $modifiedcomment);

        if(!$succes) {
            throw new \Exception ('Impossible de modifier le commentaire');
        } else {
            header('Location: index.php?action=post&id='.$post_id);
        }
        
    }
}