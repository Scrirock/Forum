<?php

namespace Scrirock\Forum\Controller;

use Scrirock\Forum\Controller\Traits\RenderViewTrait;
use Scrirock\Forum\Model\Entity\User;
use Scrirock\Forum\Model\Manager\UserManager;
use Scrirock\Forum\Model\DB;

class UserController{

    use RenderViewTrait;

    /**
     * Check the user's connexion and role
     * @param $fields
     */
    public function connexion($fields){
        if (isset($fields['name'], $fields['password'])){
            $name = (new DB)->sanitize($fields['name']);
            $password = (new DB)->sanitize($fields['password']);

            $checkAccount = (new UserManager)->checkUser($name, $password);
            if ($checkAccount){
                $checkRole = (new UserManager)->checkRole($name);
                switch ($checkRole){
                    case 1:
                        session_start();
                        $_SESSION["role"] = "user";
                        $_SESSION["name"] = $name;
                        header("Location: /");
                        exit;
                    case 2:
                        session_start();
                        $_SESSION["role"] = "moderator";
                        $_SESSION["name"] = $name;
                        header("Location: /");
                        exit;
                    case 3:
                        session_start();
                        $_SESSION["role"] = "admin";
                        $_SESSION["name"] = $name;
                        header("Location: /");
                        exit;
                }
            }
            else{
                session_start();
                $_SESSION["error"] = "Mot de passe ou Pseudo incorrect";
                header("Location: ?controller=connexion");
                exit;
            }
        }

        $this->render('connexion', 'Connexion');
    }

    /**
     * Add an user
     * @param $fields
     */
    public function addUser($fields){
        $db = new DB();
        if(isset($fields['username'], $fields['password'], $fields['mail'])) {
            if (strlen($fields['username']) > 1 && strlen($fields['username']) < 50){
                $username = $db->sanitize($fields['username']);
                $mail = $db->sanitize($fields['mail']);
                $password = password_hash($db->sanitize($fields['password']), PASSWORD_BCRYPT);

                $userObject = new User($username, $mail, $password);
                (new UserManager())->addUser($userObject);
            }
        }

        $this->render('add.user', "S'inscrire");
    }

    /**
     * Modify an user by it's id
     * @param $fields
     * @param $id
     */
    public function modifyUser($fields, $id){
        if(isset($fields['role'], $fields['name'])) {
            if (strlen($fields['name']) > 1 && strlen($fields['name']) < 50) {
                $role = (new DB())->sanitize($fields['role']);
                $name = (new DB())->sanitize($fields['name']);

                $userObject = new User($name, null, $role, $id);
                (new UserManager())->modifyUser($userObject);
            }
        }

        $this->render('modify.user', "Modifier un utilisateur", [
            'value' => (new UserManager())->getById($id)
        ]);
    }

    /**
     * Delete an user by it's id
     * @param $id
     */
    public function deleteUser($id){
        if(isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
            (new UserManager())->deleteUser($id);
        }
        else{
            header("Location: /");
        }
    }

    public function verify($id, $token){
        $id = (new DB())->sanitize($id);
        $token = (new DB())->sanitize($token);
        (new UserManager())->verifyMail($id, $token);
    }

    public function pseudoChange($fields, $name){
        if (isset($fields["pseudo"])){
            $name = (new DB())->sanitize($name);
            $pseudo = (new DB())->sanitize($fields["pseudo"]);
            (new UserManager())->pseudoChange($pseudo, $name);
        }
    }

    public function passwordChange($fields, $name){
        if (isset($fields["password"])){
            $name = (new DB())->sanitize($name);
            $password = (new DB())->sanitize($fields["password"]);
            (new UserManager())->passwordChange($password, $name);
        }
    }
}