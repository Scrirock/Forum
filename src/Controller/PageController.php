<?php

namespace Scrirock\Forum\Controller;

use Scrirock\Forum\Controller\Traits\RenderViewTrait;
use Scrirock\Forum\Model\Manager\CategoryManager;
use Scrirock\Forum\Model\Manager\CommentManager;
use Scrirock\Forum\Model\Manager\TopicManager;
use Scrirock\Forum\Model\Manager\UserManager;

class PageController {

    use RenderViewTrait;

    /**
     * Show the rules page
     */
    public function rulesPage() {
        $this->render('rules', 'Réglement');
    }

    /**
     * Show the category page
     */
    public function categoryPage() {
        $this->render('category', 'Catégorie', [
            'category' => (new CategoryManager())->getCategory(),
            'topic' => (new TopicManager())->getTopic()
        ]);
    }

    /**
     * Show the admin page
     */
    public function adminPage() {
        $this->render('admin', 'Admin Panel');
    }

    /**
     * Show the account page
     */
    public function accountPage() {
        $this->render('account', 'Mon compte');
    }

    /**
     * Show a topic page
     * @param $id
     */
    public function topic($id){
        $this->render('topic', 'Sujet', [
            'topic' => (new TopicManager())->getOneTopic($id),
            'comment' => (new CommentManager())->getComment($id)
        ]);
    }

}