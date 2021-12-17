<?php

namespace Scrirock\Forum\Model\Manager;

use Scrirock\Forum\Model\DB;
use Scrirock\Forum\Model\Entity\Comment;
use Scrirock\Forum\Model\Manager\Traits\ManagerTrait;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CommentManager {

    use ManagerTrait;

    public function getComment($id): array{
        $request = DB::getRepresentative()->prepare("
            SELECT c.id as cId, c.fk_topic as topic,
                   c.content as cContent, c.date, c.fk_user,
                   u.id as uId,
                   u.pseudo 
                FROM comment as c INNER JOIN user as u ON fk_user = u.id
                WHERE c.fk_topic = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        return $request->fetchAll();
    }

    public function getOneComment($id){
        $request = DB::getRepresentative()->prepare("SELECT * FROM comment where id = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        return $request->fetch();
    }

    public function addComment(Comment $comment){
        $request = DB::getRepresentative()->prepare("INSERT INTO comment (fk_user, fk_topic, content) 
                                                            VALUES (:user, :topic, :content)");
        $user = $comment->getUser();
        $topic = $comment->getTopic();
        $content = $comment->getContent();

        $request->bindParam(":user", $user);
        $request->bindParam(":topic", $topic);
        $request->bindParam(":content", $content);
        //$request->execute();
        //header("Location: /?controller=topic&id=".$topic);
        if ($request->execute())?><meta http-equiv="refresh" content="0;url=/?controller=topic&id=<?= $topic ?>"><?php
        exit;
    }

    public function editComment(string $content, string $id){
        $dateFormat = "j/n/Y, g:i a";
        $output = "[%datetime%] %channel% > %message% %context%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler('../Log/log.log', Logger::INFO);
        $stream->setFormatter($formatter);

        $Logger = new Logger('Coment');
        $Logger->pushHandler($stream);

        $request = DB::getRepresentative()->prepare(" UPDATE comment SET content = :content
                                                            WHERE id = :id
                                                          ");
        $request->bindParam(":content", $content);
        $request->bindParam(":id", $id);
        //$request->execute();
        $fk_topic = $this->getOneComment($id);
        //header("Location: /?controller=topic&id=".$fk_topic["fk_topic"]);
        $Logger->info("edit", [["user" => $_SESSION["name"]]]);
        if ($request->execute())?><meta http-equiv="refresh" content="0;url=/?controller=topic&id=<?= $fk_topic["fk_topic"] ?>"><?php
        exit;
    }

    public function deleteComment(string $cId, string $tId){
        $dateFormat = "j/n/Y, g:i a";
        $output = "[%datetime%] %channel% > %message% %context%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler('../Log/log.log', Logger::INFO);
        $stream->setFormatter($formatter);

        $Logger = new Logger('Comment');
        $Logger->pushHandler($stream);

        $request = DB::getRepresentative()->prepare("DELETE FROM comment WHERE id = :id");
        $request->bindParam(":id", $cId);
        $request->execute();
        $Logger->info("comment", [["user" => $_SESSION["name"]]]);
        header("Location: ?controller=topic&id=".$tId);
        exit;
    }
}