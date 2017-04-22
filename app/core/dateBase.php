<?php

/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 14.03.2017
 * Time: 0:11
 */
class DataBase
{
    protected $pdo;

    function __construct()
    {
        $host = '127.0.0.1';
        $db = 'loftschool';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }


    public function showUsers()
    {
        $userslist = $this->pdo->query('SELECT * FROM table_name');
        while ($row = $userslist->fetch()) {
            echo $row['name'] . '<br>';
        }
    }

    public function getUsersList()
    {
        $userslist = $this->pdo->query('SELECT * FROM table_name');
        while ($row = $userslist->fetch()) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUserForId($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM table_name WHERE id= :id');
        $stmt->execute([$userId]);
        $user = false;
        foreach ($stmt as $row) {
            $user = $row;
        }
        return $user;
    }

    public function is_userInDataBase($login)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM table_name WHERE login= :login');
        $stmt->execute([$login]);
        $row = $stmt->fetch(PDO::FETCH_LAZY);
        if (is_object($row)) {
            return true;
        } else {
            return false;
        }
    }

    public function saveNewUser($login, $password)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO `loftschool`.`table_name` (login, password, `name`, `age`, `description`, `photo`) VALUES (:login, :password, '', '', '', NULL)");
            $stmt->execute(array('login' => $login, 'password' => $password));
            return true;
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }

    public function deleteUser($userID)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM table_name WHERE id = :id');
            $stmt->execute([$userID]);
            return true;
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }

    public function updateUser($id, $name, $description, $age, $photo)
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE `loftschool`.`table_name` SET name = :name, `age` = :age, description = :description, photo = :photo WHERE id = :id');
            $stmt->execute(array('id' => $id, 'name' => $name, 'description' => $description, 'age' => $age, 'photo' => $photo));
            return true;
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }

    }

    public function userAndPasswordConformity($login, $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM table_name WHERE login= :login');
        $stmt->execute([$login]);
        $row = $stmt->fetch(PDO::FETCH_LAZY);
        if (is_object($row)) {
            if ($password == $row['password']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


}