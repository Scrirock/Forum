<?php

namespace Scrirock\Forum\Controller;

use Scrirock\Forum\Controller\Traits\RenderViewTrait;
use Scrirock\Forum\Model\Entity\Category;
use Scrirock\Forum\Model\Manager\CategoryManager;
use Scrirock\Forum\Model\DB;

class CategoryController{

    use RenderViewTrait;

    public function addCategory(array $fields){
        if (isset($fields["categoryName"], $fields["content"])){
            $name = (new DB)->sanitize($fields['categoryName']);
            $content = (new DB)->sanitize($fields['content']);
            (new CategoryManager())->addCategory($name, $content);
        }
    }

    public function editCategory(array $fields){
        if (isset($fields["content"], $fields["id"])){
            $content = (new DB)->sanitize($fields['content']);
            $id = (new DB)->sanitize($fields['id']);
            (new CategoryManager())->editCategory($content, $id);
        }
    }

    public function delete($id){
        $id = (new DB)->sanitize($id);
        (new CategoryManager())->deleteCategory($id);
    }

    public function archived($id){
        $id = (new DB)->sanitize($id);
        (new CategoryManager())->archived($id);
    }
}