<?php
include "Session.php";
$session = new Session();
$session->checkSession();
include "header.php";
include "sidenav.php";
include "jumbo.php";
$jumbo = new jumbo;
