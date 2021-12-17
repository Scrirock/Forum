<?php

namespace Scrirock\Forum\Controller;

use Scrirock\Forum\Controller\Traits\RenderViewTrait;
use Scrirock\Forum\Model\Entity\Topic;
use Scrirock\Forum\Model\Manager\TopicManager;
use Scrirock\Forum\Model\DB;

class TopicController{

    use RenderViewTrait;


    public function addTopic(array $fields){

        if (isset($fields["title"], $fields["content"], $fields["category"])){
            $title = (new DB())->sanitize($fields["title"]);
            $content = (new DB())->sanitize($fields["content"]);
            $category = (new DB())->sanitize($fields["category"]);

            (new TopicManager())->addTopic($title, $content, $category, $_SESSION["name"]);
        }

        $this->render('addTopic', 'Ajouter un sujet');
    }

    public function editTopic(array $fields){
        if (isset($fields["contentText"], $fields["id"])){
            $content = (new DB)->sanitize($fields['contentText']);
            $id = (new DB)->sanitize($fields['id']);
            (new TopicManager())->editTopic($content, $id);
        }
    }

    public function delete($id){
        $id = (new DB)->sanitize($id);
        (new TopicManager())->deleteTopic($id);
    }

    public function archivedTopic($id){
        $id = (new DB)->sanitize($id);
        (new TopicManager())->archivedTopic($id);
    }
}