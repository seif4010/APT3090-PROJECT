<?php
include "../../includes/DBconn.php";

if (isset($_POST['type'])) :
    $user = new User();
    switch ($_POST['type']) {

        case "login":
            echo $user->login($_POST['email'], $_POST['password']);
            break;
        case "addUser":
            echo $user->addUser($_POST['in_Email'], $_POST['in_Password'], $_POST['in_Role']);
            break;
    }
endif;


class User
{
    function login($username, $password)
    {
        $password = sha1($password);
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $query = $dbConn->query("SELECT email, password, role
                        FROM users
                        WHERE email = '$username'
                        AND password = '$password' LIMIT 1");
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['email'] = $username;
            $_SESSION['role'] = $result['role'];
            return "success";
        } else {
            return "Username or Password Error";
        }
    }

    public function addUser($email, $password, $role)
    {
        $password = sha1($password);
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "INSERT INTO users (email,password,role) VALUES (:email,:password,:role)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':email', $email);
        $query->bindparam(':password', $password);
        $query->bindparam(':role', $role);
        try {
            $query->execute();
            return "success";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    function viewAllUsers()
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM users ORDER BY user_id DESC");
    }
}
