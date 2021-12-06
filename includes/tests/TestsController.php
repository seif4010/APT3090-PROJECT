<?php
include "../../includes/DBconn.php";


if (isset($_POST['type'])) :

    $tests = new Tests();

    switch ($_POST['type']) {

        case "addTest":

            echo $tests->addTests(
                $_POST['in_TestName'],
                $_POST['in_Result'],
                $_POST['in_UserId']
            );
            break;
    }
endif;

class Tests
{
    public function addTests($name, $result, $userID)
    {
         //Encrypting test_name and result
        $resultkey = 'pass1234';
        $test_namekey = 'pass5678';
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "INSERT INTO tests (test_name,result,user_id) VALUES (AES_ENCRYPT(:test_name, '$test_namekey'), AES_ENCRYPT(:result, '$resultkey'),:user_id)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':test_name', $name);
        $query->bindparam(':result', $result);
        $query->bindparam(':user_id', $userID);
        $query->execute();
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function viewTest($id)
    {
        $resultkey = 'pass1234';
        $test_namekey = 'pass5678';
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT test_id, AES_DECRYPT(test_name, '$test_namekey') as test_name, AES_DECRYPT(result, '$resultkey') as result, patients.* from tests
                                inner join patients on patients.user_id = tests.user_id
                                 where tests.user_id = '$id'");
    }
}
