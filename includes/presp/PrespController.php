<?php
include "../../includes/DBconn.php";

if (isset($_POST['type'])) :

    $patients = new Presp();

    switch ($_POST['type']) {

        case "addPresp":

            echo $patients->addPresp(
                $_POST['in_Name'],
                $_POST['in_Expiry'],
                $_POST['in_Presp'],
                $_POST['in_Price'],
                $_POST['in_Qty']
            );
            break;
        case "updatePrespc":
            echo $patients->updatePresp(
                $_POST['in_Name'],
                $_POST['in_Expiry'],
                $_POST['in_Presp'],
                $_POST['in_Price'],
                $_POST['in_Qty'],
                $_POST['id']
            );
            break;
        case "editPatient":
            echo $patients->updatePatient(
                $_POST['in_Name'],
                $_POST['in_Expiry'],
                $_POST['in_Presp']
            );
            break;
        case "deleteDrug":
            echo $patients->deletePresp($_POST['id']);
            break;
        case "addToCart":
            echo $patients->addToCart($_POST['id']);
    }
endif;



class Presp
{

    public function addPresp($name, $expiry, $presp, $price, $qty)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();

        $query1 = $dbConn->query("SELECT * from drug where name = '$name'");
        if ($query1->rowCount() < 1) {

            $sql = "INSERT INTO drug (name,expiry,presp,price, qty) VALUES (:name,:expiry,:presp,:price, :qty)";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':name', $name);
            $query->bindparam(':expiry', $expiry);
            $query->bindparam(':presp', $presp);
            $query->bindparam(':price', $price);
            $query->bindparam(':qty', $qty);
            try {
                if ($query->execute()) :
                    return "success";
                endif;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return "Drug Already Exists";
        }
    }

    public function getAllPresp()
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM drug ORDER BY drug_id DESC");
    }

    public function getSinglePresp($id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM drug where drug_id = '$id' LIMIT 1");
    }


    public function updatePresp($name, $expiry, $presp, $price, $qty, $id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "UPDATE drug SET name=:name,expiry=:expiry,presp=:presp, price=:price, qty = :qty WHERE drug_id=:drug_id";
        $query = $dbConn->prepare($sql);
        $query->bindparam(':name', $name);
        $query->bindparam(':expiry', $expiry);
        $query->bindparam(':presp', $presp);
        $query->bindparam(':price', $price);
        $query->bindparam(':qty', $qty);
        $query->bindparam(':drug_id', $id);
        try {
            if ($query->execute()) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function deletePresp($id)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "DELETE FROM drug WHERE drug_id=:id";
        $query = $dbConn->prepare($sql);
        try {
            if ($query->execute(array(':id' => $id))) :
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function findBySearch($term)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT * FROM drug WHERE name LIKE '$term%' ORDER BY drug_id DESC");
    }

    public function addToCart($id)
    { }
}
