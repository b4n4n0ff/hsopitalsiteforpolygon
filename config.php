<?php
session_start();

// MariaDB
define('DB_HOST', 'localhost');
define('DB_NAME', 'hospital_db');
define('DB_USER', 'hospital_user'); 
define('DB_PASS', 'HospitalPass123!');

$hospital_name = "Городская больница №1";
$hospital_address = "г. Москва, ул. Медицинская, д. 15";
$hospital_phone = "+7 (495) 123-45-67";

// подключение к бд
function getDB() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    } catch(PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}

// проверка авторизации
function checkAuth() {
    return isset($_SESSION['user_id']);
}

// проверка роли admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// редирект если не авторизован
function requireAuth() {
    if (!checkAuth()) {
        header("Location: login.php");
        exit();
    }
}

// редирект если не admin
function requireAdmin() {
    requireAuth();
    if (!isAdmin()) {
        header("Location: dashboard.php");
        exit();
    }
}

// логи
function log_action($action, $user_id = null) {
    $user_id = $user_id ?? $_SESSION['user_id'] ?? 'guest';
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $log_entry = "$timestamp | $ip | $user_id | $action\n";
    file_put_contents('hospital_audit.log', $log_entry, FILE_APPEND);
}
?>
