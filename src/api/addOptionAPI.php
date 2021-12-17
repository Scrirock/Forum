<?php

use Scrirock\Forum\Model\Manager\CategoryManager;

require "../../vendor/autoload.php";

header('Content-Type: application/json');

$manager = new CategoryManager();
if ($_SERVER['REQUEST_METHOD'] === "GET"){
    echo getCategory($manager);
}

function getCategory(CategoryManager $manager): string {
    $response = [];

    $data = $manager->getCategory();
    foreach($data as $category) {

        $response[] = [
            'id' => $category["id"],
            'name' => $category["name"],
        ];
    }
    return json_encode($response);
}