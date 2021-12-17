<?php

namespace Scrirock\Forum\Controller\Traits;

trait RenderViewTrait {

    /**
     * Show any asked view
     * @param string $view
     * @param string $title
     * @param array|null $var
     */
    public function render(string $view, string $title, array $var = null): void {
        ob_start();
        require_once  "../View/$view.view.php";
        $html = ob_get_clean();
        require_once '../View/_partials/base.view.php';
    }
}