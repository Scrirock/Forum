<?php

namespace Scrirock\Forum\Controller;

use Scrirock\Forum\Controller\Traits\RenderViewTrait;
use Scrirock\Forum\Model\Entity\Comment;
use Scrirock\Forum\Model\Manager\CommentManager;
use Scrirock\Forum\Model\DB;
use Scrirock\Forum\Model\Manager\UserManager;

class CommentController{

    use RenderViewTrait;

    public function addComment(array $fields, int $id){
        if (isset($fields["content"], $_GET["id"], $_SESSION["name"])){
            $content = (new DB)->sanitize($fields['content']);
            $userObject = (new UserManager())->getByName($_SESSION["name"]);

            $commentObject = new Comment(null, $userObject->getId(), $id, $content);
            (new CommentManager())->addComment($commentObject);
        }
    }

    public function editComment(array $fields){
        if (isset($fields["contentComment"], $fields["id"])){
            $content = (new DB)->sanitize($fields['contentComment']);
            $id = (new DB)->sanitize($fields['id']);
            (new CommentManager())->editComment($content, $id);
        }
    }

    public function delete($cId, $tId){
        $cId = (new DB)->sanitize($cId);
        $tId = (new DB)->sanitize($tId);
        (new CommentManager())->deleteComment($cId, $tId);
    }

}