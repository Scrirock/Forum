<?php

use Scrirock\Forum\Controller\HomeController;
use Scrirock\Forum\Controller\PageController;
use Scrirock\Forum\Controller\UserController;
use Scrirock\Forum\Controller\CategoryController;
use Scrirock\Forum\Controller\TopicController;
use Scrirock\Forum\Controller\CommentController;

use Omnipay\Omnipay;

require dirname(__FILE__) . '/../vendor/autoload.php';

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['controller'])) {
    switch ($_GET['controller']) {
        case 'rules':
            (new PageController())->rulesPage();
            break;
        case 'category':
            (new PageController())->categoryPage();
            (new CategoryController())->editCategory($_POST);
            break;
        case 'admin':
            (new PageController())->adminPage();
            (new CategoryController())->addCategory($_POST);
            break;
        case 'myAccount':
            (new PageController())->accountPage();
            (new UserController())->pseudoChange($_POST, $_SESSION["name"]);
            (new UserController())->passwordChange($_POST, $_SESSION["name"]);
            break;
        case 'connexion':
            $controller = new UserController();
            $controller->connexion($_POST);
            break;
        case 'addUser':
            $controller = new UserController();
            $controller->addUser($_POST);
            break;
        case 'topic':
            if (isset($_GET["id"])){
                $controller = new PageController();
                $controller->topic($_GET["id"]);
                (new CommentController())->addComment($_POST, $_GET["id"]);
                (new CommentController())->editComment($_POST);
                (new TopicController())->editTopic($_POST);
            }
            break;
        case 'addTopic':
            (new TopicController())->addTopic($_POST);
            break;
        case 'deleteCategory':
            if (isset($_GET["id"])){
                (new CategoryController())->delete($_GET["id"]);
            }
            break;
        case 'deleteComment':
            if (isset($_GET["cId"], $_GET["tId"])){
                (new CommentController())->delete($_GET["cId"], $_GET["tId"]);
            }
            break;
        case 'deleteTopic':
            if (isset($_GET["id"])){
                (new TopicController())->delete($_GET["id"]);
            }
            break;
        case 'archived':
            if (isset($_GET["id"])){
                (new CategoryController())->archived($_GET["id"]);
            }
            break;
        case 'archivedTopic':
            if (isset($_GET["id"])){
                (new TopicController())->archivedTopic($_GET["id"]);
            }
            break;
        case 'paypal':

            $gateway = Omnipay::create('PayPal_Express');
            $gateway->setUsername('sb-43wjmr8132221_api1.business.example.com');
            $gateway->setPassword('QPZRWDADS5LL7ZHE');
            $gateway->setSignature('AmnR532wuedWn.NQPRnhSqcNFxQAAC4bM6cfwCmIy8XDRCCVL06K0yvd');

            $gateway->setTestMode(TRUE);

            try {
                $response = $gateway->purchase(array('amount' => '10.00', 'returnURL' => 'localhost:8080', 'cancelURL' => 'localhot:8080'))->send();
                if ($response->isSuccessful()) {
                    // mark order as complete
                } elseif ($response->isRedirect()) {
                    $response->redirect();
                } else {
                    // display error to customer
                    exit($response->getMessage());
                }
            } catch (\Exception $e) {
                // internal error, log exception and display a generic message to the customer
                echo $e->getMessage() . "<br>";
                exit('Sorry, there was an error processing your payment. Please try again later.');
            }

            break;
        default:
            (new HomeController())->homePage();
            break;
    }
}
elseif (isset($_GET['token'], $_GET['id'])){
    $controller = new UserController();
    $controller->verify($_GET['id'], $_GET['token']);
}
else {
    (new HomeController())->homePage();
}