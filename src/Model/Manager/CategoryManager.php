<?php

namespace Scrirock\Forum\Model\Manager;

use Scrirock\Forum\Model\DB;
use Scrirock\Forum\Model\Entity\Category;
use Scrirock\Forum\Model\Manager\Traits\ManagerTrait;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CategoryManager {

    use ManagerTrait;

    public function addCategory(string $name, string $content){
        $request = DB::getRepresentative()->prepare("INSERT INTO category (name, description) VALUES (:name, :content)");
        $request->bindParam(":name", $name);
        $request->bindParam(":content", $content);
        $request->execute();
    }

    public function getCategory(): array{
        $request = DB::getRepresentative()->prepare("SELECT * FROM category");
        $request->execute();
        return $request->fetchAll();
    }

    public function editCategory(string $content, string $id){
        $dateFormat = "j/n/Y, g:i a";
        $output = "[%datetime%] %channel% > %message% %context%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler('../Log/log.log', Logger::INFO);
        $stream->setFormatter($formatter);

        $Logger = new Logger('Category');
        $Logger->pushHandler($stream);

        $request = DB::getRepresentative()->prepare(" UPDATE category SET description = :content
                                                            WHERE id = :id
                                                          ");
        $request->bindParam(":content", $content);
        $request->bindParam(":id", $id);
        if ($request->execute()){
            $Logger->info("edit", [["user" => $_SESSION["name"]]]);
            ?><meta http-equiv="refresh" content="0;url=/?controller=category"><?php
        }
    }

    public function deleteCategory(string $id){
        $dateFormat = "j/n/Y, g:i a";
        $output = "[%datetime%] %channel% > %message% %context%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler('../Log/log.log', Logger::INFO);
        $stream->setFormatter($formatter);

        $Logger = new Logger('Category');
        $Logger->pushHandler($stream);

        $request = DB::getRepresentative()->prepare("DELETE FROM category WHERE id = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        $Logger->info("delete", [["user" => $_SESSION["name"]]]);
        header("Location: ?controller=category");
    }

    public function checkArchived($id, $topicId = null){
        if (isset($topicId)){
            $request = DB::getRepresentative()->prepare("SELECT fk_category FROM topic WHERE id = :id");
            $request->bindParam(":id", $topicId);
            $request->execute();
            $id = $request->fetch()["fk_category"];
        }
        $request = DB::getRepresentative()->prepare("SELECT archived FROM category WHERE id = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        $data = $request->fetch();
        return $data["archived"];
    }

    public function archived(string $id){
        if ($this->checkArchived($id)) $value = 0;
        else $value = 1;

        $request = DB::getRepresentative()->prepare(" UPDATE category SET archived = :value
                                                            WHERE id = :id
                                                          ");
        $request->bindParam(":value", $value);
        $request->bindParam(":id", $id);
        $request->execute();
        header("Location: ?controller=category");
    }

}