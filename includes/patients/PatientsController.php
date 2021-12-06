<?php
include "../../includes/DBconn.php";

if (isset($_POST['type'])) :

    $patients = new PatientsController();

    switch ($_POST['type']) {

        case "addPatient":

            echo $patients->addPatient(
                $_POST['in_Firstname'],
                $_POST['in_Lastname'],
                $_POST['in_Dob'],
                $_POST['in_Address'],
                $_POST['in_Married'],
                $_POST['in_Contact']
            );
            break;
        case "editPatient":
            echo $patients->updatePatient(
                $_POST['id'],
                $_POST['in_Firstname'],
                $_POST['in_Lastname'],
                $_POST['in_Dob'],
                $_POST['in_Address'],
                $_POST['in_Married'],
                $_POST['in_Contact']
            );
            break;
        case "deletePatient":
            echo $patients->deletePatient($_POST['id']);
            break;
        case "addDiag":
            echo $patients->addDiag(
                $_POST['id'],
                $_POST['in_Temp'],
                $_POST['in_Bp'],
                $_POST['in_Presp1'],
                $_POST['in_Remarks'],
                isset($_POST['test_id']) ? $_POST['test_id'] : ''
            );
            break;
        case "editChild":
            echo $patients->updateGrowth(
                $_POST['id'],
                $_POST['in_Gender'],
                $_POST['in_Weight'],
                $_POST['in_Height'],
                $_POST['in_HeadC'],
                $_POST['in_Bmi']

            );
            break;
        case "refer":
            echo $patients->refer(
                $_POST['name'],
                $_POST['id'],
                $_POST['reason']
            );
            break;
    }
endif;
class PatientsController
{
    function addPatient($firstname, $lastname, $dob, $address, $married, $contact)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $date =  date("Y-m-d");
        $sql = "INSERT INTO patients (firstname,lastname,dob,address,dor,married,contact) VALUES (:firstname,:lastname,:dob,:address,:dor,:married,:contact)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':firstname', $firstname);
        $query->bindparam(':lastname', $lastname);
        $query->bindparam(':dob', $dob);
        $query->bindparam(':address', $address);
        $query->bindparam(':dor', $date);
        $query->bindparam(':married', $married);
        $query->bindparam(':contact', $contact);
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function viewAllPatients()
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM patients ORDER BY user_id DESC");
    }
    public function viewAllChildren()
    {
        $time = strtotime("-18 years", time());
        $date = date("Y-m-d", $time);

        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM patients where dob > '$date' ORDER BY user_id DESC");
    }
    public function viewAllChildrenByDate($years)
    {
        $time = strtotime("-" . $years . "years", time());
        $date = date("Y-m-d", $time);
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM patients where dob > '$date' ORDER BY user_id DESC");
    }
    public function getPatient($id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM patients where user_id = '$id' LIMIT 1");
    }


    public function updatePatient($id, $firstname, $lastname, $dob, $address, $married, $contact)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "UPDATE patients SET firstname=:firstname,lastname=:lastname,dob=:dob,address=:address,married=:married,contact=:contact WHERE user_id=:user_id";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':user_id', $id);
        $query->bindparam(':firstname', $firstname);
        $query->bindparam(':lastname', $lastname);
        $query->bindparam(':dob', $dob);
        $query->bindparam(':address', $address);
        $query->bindparam(':married', $married);
        $query->bindparam(':contact', $contact);
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function deletePatient($id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "DELETE FROM patients WHERE user_id=:user_id";
        $query = $dbConn->prepare($sql);
        try {
            if ($query->execute(array(':user_id' => $id))) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    function addDiag($id, $temp, $bp, $presp, $remarks, $test_id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "INSERT INTO diagnosis (user_id, temp,bp,presp1,remarks, test_id) VALUES (:id, :temp,:bp,:presp1,:remarks,:test_id)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':id', $id);
        $query->bindparam(':temp', $temp);
        $query->bindparam(':bp', $bp);
        $query->bindparam(':presp1', $presp);
        $query->bindparam(':remarks', $remarks);
        $query->bindparam(':test_id', $test_id);
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function viewChildHeight($id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT growth.*, patients.*
                                from patients
                                LEFT JOIN growth on growth.user_id = patients.user_id
                                WHERE patients.user_id = $id
                                ORDER BY growth.created DESC");
    }

    function updateGrowth($user_id, $gender, $weight, $height, $headC, $bmi)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "INSERT INTO growth (user_id, weight,height, gender, headc, bmi) VALUES (:id, :w,:h, :g, :hc, :bmi)";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':id', $user_id);
        $query->bindparam(':w', $weight);
        $query->bindparam(':h', $height);
        $query->bindparam(':g', $gender);
        $query->bindparam(':hc', $headC);
        $query->bindparam(':bmi', $bmi);
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function viewDiag($id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT patients.*, diagnosis.*
                                FROM patients
                                LEFT JOIN diagnosis
                                ON patients.user_id = diagnosis.user_id 
                                WHERE patients.user_id = '$id' LIMIT 1");
    }

    function refer($referred, $id, $reason)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "UPDATE patients SET referred=:re, reason = :r WHERE user_id=:user_id";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':user_id', $id);
        $query->bindparam(':re', $referred);
        $query->bindparam(':r', $reason);
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
