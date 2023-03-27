<?php

namespace Application\Model\Comment;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Comment
{
    public string $author;
    public string $frenchCreationDate;
    public string $comment;
    public string $id;
}

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getComments(string $post): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$post]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->comment = $row['comment'];
            $comment->id = $row['id'];
            $comments[] = $comment;
        }

        return $comments;
    }

    public function createComment(string $post, string $author, string $comment): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([$post, $author, $comment]);

        return ($affectedLines > 0);
    }

    public function modifyComment(string $comment_id, string $modifiedComment): bool 
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE comments SET comment= ?, comment_date=NOW() WHERE id= ?'
        );
        $affectedLines = $statement->execute([$modifiedComment,$comment_id]);

        return ($affectedLines > 0);
    }
}
