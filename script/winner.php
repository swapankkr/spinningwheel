<?php
require_once './includes/start.php';
require_once './includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $winner = $_POST['winner'] ?? '';
    query("UPDATE wheels SET winner = '$winner' WHERE id = '$id'");
    response([]);exit;
}
error("Method not allowed");
