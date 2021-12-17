<?php

namespace Scrirock\Forum\Model\Manager;

use Scrirock\Forum\Model\DB;
use Scrirock\Forum\Model\Entity\User;
use Scrirock\Forum\Model\Manager\Traits\ManagerTrait;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class UserManager {

    use ManagerTrait;

    /**.
     * Return an user by it's ID
     * @param int $id
     * @return User
     */
    public function getById(int $id): User {
        $user = new User();
        $request = DB::getRepresentative()->prepare("SELECT id, pseudo FROM user WHERE id = :id");
        $request->bindValue(':id', $id);
        if($request->execute()) {
            $useData = $request->fetch();
            if($useData) {
                $user->setId($useData['id']);
                $user->setPassword('');
                $user->setName($useData['username']);
            }
        }
        return $user;
    }

    /**
     * Return an user by it's name
     * @param string $name
     * @return User
     */
    public function getByName(string $name): User {
        $user = new User();
        $request = DB::getRepresentative()->prepare("SELECT id, pseudo FROM user WHERE pseudo = :name");
        $request->bindValue(':name', $name);
        $result = $request->execute();
        if($result) {
            $useData = $request->fetch();
            if($useData) {
                $user->setId($useData['id']);
                $user->setPassword('');
                $user->setName($useData['pseudo']);
            }
        }
        return $user;
    }

    /**
     * Return true if the user exist and the password is correct
     * @param $name
     * @param $password
     * @return bool
     */
    public function checkUser($name, $password): bool{
        $request = DB::getRepresentative()->prepare("SELECT * FROM user WHERE pseudo = :name");
        $request->bindValue(':name', $name);

        if($request->execute()) {
            $userData = $request->fetch();
            if(password_verify($password, $userData["password"])) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     * Return the role of an user
     * @param $name
     * @return int
     */
    public function checkRole($name): int{
        $request = DB::getRepresentative()->prepare("SELECT * FROM user WHERE pseudo = :name");
        $request->bindValue(':name', $name);

        if($request->execute()) {
            $userData = $request->fetch();
            return $userData['fk_role'];
        }
    }

    /**
     * Avoid an user to have the same pseudo of another one
     * @param $name
     * @param null $id
     * @return bool
     */
    public function checkUserName($name, $id = null): bool{
        $request = DB::getRepresentative()->prepare("SELECT id, pseudo FROM user");
        $request->execute();
        $check = true;

        $userData = $request->fetchAll();
        foreach ($userData as $username){
            if ($username['pseudo'] === $name && $username['id'] != $id){
                $check = false;
            }
        }
        return $check;
    }

    /**
     * Add a user into the database
     * @param User $user
     */
    public function addUser(User $user){
        $dateFormat = "j/n/Y, g:i a";
        $output = "[%datetime%] %channel% > %message% %context%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler('../Log/log.log', Logger::INFO);
        $stream->setFormatter($formatter);

        $Logger = new Logger('User');
        $Logger->pushHandler($stream);

        if ($this->checkUserName($user->getName())){
            $request = DB::getRepresentative()->prepare("
            INSERT INTO user (fk_role, pseudo, mail, password)
                VALUES (:role, :username, :mail, :password)
            ");

            $role = $user->getRole();
            $username = $user->getName();
            $mail = $user->getMail();
            $password = $user->getPassword();

            $request->bindParam(":role", $role);
            $request->bindParam(":username", $username);
            $request->bindParam(":mail", $mail);
            $request->bindParam(":password", $password);
            if ($request->execute()){
                $Logger->info("Add");
                $this->sendMail(DB::getRepresentative()->lastInsertId(), $mail);
                header("Location: /");
            }
            else{
                $_SESSION["error?"] = "Une erreur est survenu, veuillez réessayer";
                header("Location: ?controller=addUser");
            }
        }
        else{
            $_SESSION["error?"] = "Ce nom d'utilisateur est deja prit";
            header("Location: ?controller=addUser");
        }
    }

    /**
     * Modify an user
     * @param User $user
     */
    public function modifyUser(User $user){
        if ($this->checkUserName($user->getName(), $user->getId())) {
            $request = DB::getRepresentative()->prepare("
            UPDATE user SET fk_role = :role,
                            pseudo = :username  
                        WHERE id = :id 
        ");

            $role = $user->getRole();
            $username = $user->getName();
            $id = $user->getId();

            $request->bindParam(":role", $role);
            $request->bindParam(":username", $username);
            $request->bindParam(":id", $id);

            if ($request->execute()) {
                header("Location: /");
            }
            else {
                session_start();
                $_SESSION["error"] = "Une erreur est survenu, veuillez réessayer";
                header("Location: /");
            }
        }
        else{
            session_start();
            $_SESSION["error"] = "Ce nom d'utilisateur est deja prit";
            header("Location: /");
        }
    }

    /**
     * Delete an user
     * @param $id
     */
    public function deleteUser($id){
        $request = DB::getRepresentative()->prepare("DELETE FROM user WHERE id = :id");
        $request->bindParam(':id', $id);
        $request->execute();
        header("Location: ?controller=admin");
    }

    /**
     * Return all the user
     * @return array
     */
    public function getAll(): array{
        $request = DB::getRepresentative()->prepare("
            SELECT u.id as uid,
                   u.pseudo, u.fk_role,
                   r.id as rid,
                   r.name as role
                FROM user as u INNER JOIN role as r ON fk_role = r.id");
        if($request->execute()) {
            return $request->fetchAll();
        }
    }

    /**
     * Send a mail to activate the account
     * @param string $id
     * @param string $mail
     */
    public function sendMail(string $id, string $mail){
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);

        $request = DB::getRepresentative()->prepare("INSERT INTO token (fk_user, token) 
                                                                    VALUES (:user, :token)");
        $request->bindParam(":user", $id);
        $request->bindParam(":token", $token);
        $request->execute();

        $message = "Activez votre compte en cliquand ici \n http://localhost:8080/?token=".$token."&id=".$id;
        $message = wordwrap($message, 70, "\r\n");
        //mail($mail, 'Validation', $message);
    }

    /**
     * Update the bdd for the active account
     * @param string $idUrl
     * @param string $tokenUrl
     */
    public function verifyMail(string $idUrl, string $tokenUrl){
        $request = DB::getRepresentative()->prepare("SELECT * FROM token WHERE fk_user = :id");
        $request->bindParam(":id", $idUrl);
        if ($request->execute()){
            $data = $request->fetch();
            if ($tokenUrl === $data["token"]){
                $request = DB::getRepresentative()->prepare("UPDATE user SET confirmation = 1 WHERE id = :id");
                $request->bindParam(":id", $data["fk_user"]);
                $request->execute();
                header("Location: /");
            }
        }
    }

    /**
     * Write a message if the user didn't activate his account
     * @param string $pseudo
     * @return string
     */
    public function verifyAccount(string $pseudo): string{
        $request = DB::getRepresentative()->prepare("SELECT confirmation FROM user WHERE pseudo = :pseudo");
        $request->bindParam(":pseudo", $pseudo);

        $request->execute();
        $data = $request->fetch();
        if (!$data["confirmation"]) return true;
        else return false;
    }

    /**
     * Return the id of the user
     * @param $name
     * @return mixed
     */
    public function idReturnByName($name){
        $request = DB::getRepresentative()->prepare("SELECT id FROM user WHERE pseudo = :pseudo");
        $request->bindParam(":pseudo", $name);
        $request->execute();

        return $request->fetch();
    }

    public function pseudoChange(string $pseudo, string $name){
        $request = DB::getRepresentative()->prepare("UPDATE user SET pseudo = :pseudo WHERE pseudo = :name");
        $request->bindParam(":name", $name);
        $request->bindParam(":pseudo", $pseudo);
        $request->execute();
        $_SESSION["name"] = $pseudo;
        header("Location: /?controller=myAccount");
    }

    public function passwordChange(string $password, string $name){
        $request = DB::getRepresentative()->prepare("UPDATE user SET password = :password WHERE pseudo = :name");
        $request->bindParam(":name", $name);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $request->bindParam(":password", $password);
        $request->execute();
        header("Location: /?controller=myAccount");
    }
}