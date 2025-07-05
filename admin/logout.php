<?php
require_once '../config/DataBase.php';

if (isset($_POST['logout'])) {
 
    session_unset();

    
    session_destroy();

    header("Location: acces.php");
    exit();
}

