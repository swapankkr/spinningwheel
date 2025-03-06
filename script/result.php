<?php
require_once './includes/start.php';
require_once './includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $result = $_POST['result'] ?? '';
    query("UPDATE wheels SET result = '$result' WHERE id = '$id'");
    response([]);exit;
}
error("Method not allowed");
