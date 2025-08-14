<?php
class Session {
    public static function requireLogin($roles = null) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
        if ($roles) {
            // Permitir array o string
            if (is_array($roles)) {
                if (!in_array($_SESSION['role'], $roles)) {
                    header("Location: dashboard.php?no_access=1");
                    exit();
                }
            } else {
                if ($_SESSION['role'] !== $roles) {
                    header("Location: dashboard.php?no_access=1");
                    exit();
                }
            }
        }
    }
}
