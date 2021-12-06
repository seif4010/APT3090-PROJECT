<?php
include "../../includes/req/cart.php";
require '../../includes/PHPMailer/src/Exception.php';
require '../../includes/PHPMailer/src/PHPMailer.php';
require '../../includes/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if (isset($_POST['type'])) :

    $req = new Req();

    switch ($_POST['type']) {

        case "addToCart":
            echo $req->addToCart($_POST['id'], $_POST['name'], $_POST['expiry'], $_POST['presp'], $_POST['price'], $_POST['qty']);
            break;
        case "removeFromCart":
            echo $req->removeFromCart($_POST['id'], $_POST['name'], $_POST['expiry'], $_POST['presp'], $_POST['price'], $_POST['qty']);
            break;
        case "saveCart":
            echo $req->saveCart();
            break;
        case "approve":
            echo $req->approve($_POST['id']);
            break;
        case "deny":
            echo $req->deny($_POST['id']);
            break;
    }
endif;


class Req
{
    function addToCart($id, $name, $expiry, $prep, $price, $qty)
    {
        $cart = new cart();
        return $cart->addToCart($id, $name, $expiry, $prep, $price, $qty);
    }

    function getCart($filename)
    {
        $cart = new cart();
        return $cart->getCart($filename);
    }
    function removeFromCart($id, $name, $expiry, $prep, $price, $qty)
    {
        $cart = new cart();
        return $cart->removeFromCart($id, $name, $expiry, $prep, $price, $qty);
    }
    function clearCart()
    {
        $cart = new cart();
        return $cart->deleteCart();
    }

    function findReqs()
    {
        include "../../includes/DBconn.php";
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT req_id, created, status, count(req_id) as count
        from requisitions
        group by req_id, created, status
        having count(req_id)");
    }
    function findReqsByID($email)
    {
        include "../../includes/DBconn.php";
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT req_id, created, status, count(req_id) as count
        from requisitions
        where email = '$email'
        group by req_id, created, status
        having count(req_id)");
    }


    function viewReq($id)
    {
        include "../../includes/DBconn.php";
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT requisitions.*, drug.*, requisitions.created
        FROM requisitions
        INNER JOIN drug ON drug.drug_id = requisitions.drug_id
        WHERE requisitions.req_id = $id
        ORDER BY requisitions.created
        DESC");
    }

    function viewReqByDate($from, $to)
    {
        include "../../includes/DBconn.php";
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT requisitions.req_id, count(requisitions.drug_id) as count, drug.name, requisitions.created, requisitions.qty
        FROM requisitions
        INNER JOIN drug ON drug.drug_id = requisitions.drug_id
        WHERE requisitions.created between '$from' and '$to'
        GROUP BY requisitions.drug_id
        ORDER BY requisitions.drug_id
        DESC");
    }


    function viewReqs()
    {
        include "../../includes/DBconn.php";
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        return $dbConn->query("SELECT requisitions.req_id, count(requisitions.drug_id) as count, drug.name, requisitions.created, requisitions.qty
                                FROM requisitions
                                INNER JOIN drug ON drug.drug_id = requisitions.drug_id
                                GROUP BY requisitions.drug_id
                                ORDER BY requisitions.drug_id
                                DESC");
    }


    function saveCart()
    {
        session_start();
        $email = $_SESSION['email'];
        include "../../includes/DBconn.php";
        $cartList = $this->getCart('cart.txt');
        //shift 1st array
        // for ($i = 0; $i < 5; $i++) { // } //return json_encode($cartList); $db=new DBconnection(); $dbConn=$db->getConnection();
        $reqID = rand(1, 255);
        // return json_encode($cartList);
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        try {
            foreach ($cartList as $item) {
                if (isset($item[5])) :
                    $sql = "INSERT INTO requisitions (req_id,drug_id,qty, email)
                            VALUES ($reqID,$item[0],$item[5],'$email')";
                    $query = $dbConn->prepare($sql);
                    if ($query->execute()) :
                        $this->updateReq($dbConn, $item[0], $item[5]);
                    endif;
                endif;
            }
            $this->clearCart();
            return "success";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function updateReq($dbConn, $id, $qty)
    {
        $sql = "UPDATE drug
                SET qty = qty - $qty
                WHERE drug_id = $id";
        $dbConn->prepare($sql)->execute();
    }

    function approve($id)
    {
        include "../../includes/DBconn.php";
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "UPDATE requisitions
                SET status = 1
                WHERE req_id = $id";
        $query = $dbConn->prepare($sql);
        try {
            if ($query->execute()) :
                $this->sendEmail($id, "Approved");
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    function deny($id)
    {
        include "../../includes/DBconn.php";
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $sql = "UPDATE requisitions
                SET status = 2
                WHERE req_id = $id";
        $query = $dbConn->prepare($sql);
        try {
            if ($query->execute()) :
                $this->sendEmail($id, "Denied");
                return "success";
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function sendEmail($Reqid, $status)
    {
        $db = new DBconnection();
        $dbConn = $db->getConnection();
        $query = $dbConn->query("SELECT email from requisitions where req_id = $Reqid LIMIT 1");
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $email = $result['email'];


        $to = $email;
        $from = 'HIS@gmail.com';

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsHTML(true);
        $mail->Username = "brianmsyamboza@gmail.com"; // your gmail address
        $mail->Password = "0881398343"; // password
        $mail->SetFrom("brianmsyamboza@gmail.com");
        $mail->Subject = "Hospital Management System"; // Mail subject
        $mail->Body = "Your Requisition has been " . $status;
        $mail->AddAddress($to);
        if (!$mail->Send()) {
            echo "Failed to send mail";
            exit;
        }
        return "success";
    }
}
