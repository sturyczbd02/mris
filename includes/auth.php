<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /mris/public/login.php");
    exit;
}
?>