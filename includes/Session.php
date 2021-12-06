<?php
class Session
{

    public function init()
    {
        if (!PHP_SESSION_ACTIVE) :
            session_start();
        endif;
    }


    public function getAuthSession()
    {
        if (isset($_SESSION['email'])) {
            return $_SESSION['email'];
        } else {
            echo $this->redirectNonAuth();
        }
    }

    public function checkSession()
    {
        $this->init();
        $this->getAuthSession();
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            echo $this->redirectNonAuth();
        }
    }
    function redirectNonAuth()
    {
        return "<script>alert('Not Authorised');window.location.href = '../../src/index/index.php'</script>";
    }
    public function logout()
    {
        session_start();
        if (isset($_SESSION['email'])) {
            session_destroy();
        }
        echo $this->redirectNonAuth();
    }

    public function redirect($roleId)
    {
        if ($roleId == 1) {
            header('Location:admin.php');
        } else {
            header('Location:home.php');
        }
    }
}
