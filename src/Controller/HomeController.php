<?php

namespace Scrirock\Forum\Controller;

use Scrirock\Forum\Controller\Traits\RenderViewTrait;

class HomeController {

    use RenderViewTrait;

    /**
     * Show the home page
     */
    public function homePage() {
        $this->render('home', 'Forum');
    }

}