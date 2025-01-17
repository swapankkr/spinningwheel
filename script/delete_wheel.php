<?php
require_once './includes/start.php';
require_once './includes/db.php';

$wheel_id = $wheel_id = isset($_GET['id']) ? $_GET['id'] : header('Location: index.php');
$user = user();
query("DELETE FROM wheels WHERE id = '$wheel_id' AND user_id = '$user->id'");
header('Location: ../index.php');exit;