<?php

function require_role($roles) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $roles)) {
        header("Location: .../public/dashboard.php");
        exit;
    }
}
