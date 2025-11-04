<?php
// Конфигурация больницы
$hospital_name = "Городская больница №1";
$hospital_address = "г. Москва, ул. Медицинская, д. 15";
$hospital_phone = "+7 (495) 123-45-67";
$admin_email = "admin@hospital.local";

// Настройки базы данных
$db_config = [
    'host' => 'localhost',
    'user' => 'hospital_user', 
    'pass' => 'HospitalPass123!',
    'name' => 'hospital_db'
];

// Логирование действий
function log_hospital_action($action, $user = 'guest') {
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $log_entry = "$timestamp | $ip | $user | $action\n";
    file_put_contents('hospital_audit.log', $log_entry, FILE_APPEND);
}
?>