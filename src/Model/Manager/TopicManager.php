<?php

namespace Scrirock\Forum\Model\Manager;

use Scrirock\Forum\Model\DB;
use Scrirock\Forum\Model\Entity\Topic;
use Scrirock\Forum\Model\Manager\Traits\ManagerTrait;
use Scrirock\Forum\Model\Manager\UserManager;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TopicManager {

    use ManagerTrait;

    public function getTopic(): array{
        $request = DB::getRepresentative()->prepare("SELECT * FROM topic");
        $request->execute();
        return $request->fetchAll();
    }

    public function getOneTopic($id){
        $request = DB::getRepresentative()->prepare("
            SELECT t.title as tTitle, t.id,
                   t.content as tContent, t.fk_user,
                   t.close,
                   u.id as uId,
                   u.pseudo 
                FROM topic as t INNER JOIN user as u ON fk_user = u.id
                WHERE t.id = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        return $request->fetch();
    }

    public function addTopic(string $title, string $content, string $category, $name){
        $user_fk = (new UserManager())->idReturnByName($name);
        $request = DB::getRepresentative()->prepare("INSERT INTO topic (fk_category, fk_user, title, content)
                                                                VALUES (:category, :user, :title, :content)");
        $request->bindParam(":category", $category);
        $request->bindParam(":user", $user_fk["id"]);
        $request->bindParam(":title", $title);
        $request->bindParam(":content", $content);

        if ($request->execute()) header("Location: ?controller=topic&id=".DB::getRepresentative()->lastInsertId());
    }

    public function editTopic(string $content, string $id){
        $dateFormat = "j/n/Y, g:i a";
        $output = "[%datetime%] %channel% > %message% %context%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler('../Log/log.log', Logger::INFO);
        $stream->setFormatter($formatter);

        $Logger = new Logger('Topic');
        $Logger->pushHandler($stream);

        $request = DB::getRepresentative()->prepare(" UPDATE topic SET content = :content
                                                            WHERE id = :id
                                                          ");
        $request->bindParam(":content", $content);
        $request->bindParam(":id", $id);
//        $request->execute();
//        header("Location: ?controller=topic&id=".$id);
        if ($request->execute()){
            $Logger->info("edit", [["user" => $_SESSION["name"]]]);
            ?><meta http-equiv="refresh" content="0;url=/?controller=topic&id=<?= $id ?>"><?php
        }
    }

    public function deleteTopic(string $id){
        $dateFormat = "j/n/Y, g:i a";
        $output = "[%datetime%] %channel% > %message% %context%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler('../Log/log.log', Logger::INFO);
        $stream->setFormatter($formatter);

        $Logger = new Logger('Topic');
        $Logger->pushHandler($stream);

        $request = DB::getRepresentative()->prepare("DELETE FROM topic WHERE id = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        $Logger->info("delete", [["user" => $_SESSION["name"]]]);
        header("Location: ?controller=category");
    }

    public function checkArchived($id){
        $request = DB::getRepresentative()->prepare("SELECT close FROM topic WHERE id = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        $data = $request->fetch();
        return $data["close"];
    }

    public function archivedTopic(string $id){
        if ($this->checkArchived($id)) $value = 0;
        else $value = 1;

        $request = DB::getRepresentative()->prepare(" UPDATE topic SET close = :value
                                                            WHERE id = :id
                                                          ");
        $request->bindParam(":value", $value);
        $request->bindParam(":id", $id);
        $request->execute();
        header("Location: ?controller=topic&id=".$id);
    }
}