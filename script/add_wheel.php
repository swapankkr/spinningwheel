<?php
require_once './includes/start.php';
require_once './includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['id'])){
        $wheel_id = $_POST['id'];
        $name = trim($_POST['wheel_name']);
        $name = $name ? $name : 'Untitled Wheel';
        $datetime = date('Y-m-d H:i:s');
        $user_id = user()->id;
        query("UPDATE wheels SET user_id = '$user_id', name = '$name', datetime = '$datetime' WHERE id = '$wheel_id'");
        query("DELETE FROM wheel_members WHERE wheel_id = $wheel_id");
        $sql = "INSERT INTO wheel_members (wheel_id, name, weight, color) VALUES " . join(',', array_map(function ($item) use ($wheel_id) {
            $weight = is_numeric($item['weight']) ? $item['weight'] : 1;
            return "('$wheel_id', '{$item['name']}', '$weight', '{$item['color']}')";
        }, $_POST['item']));
        query($sql);
        response(['wheel_id' => $wheel_id]);exit;
    }else{
        $name = trim($_POST['wheel_name']);
        $name = $name ? $name : 'Untitled Wheel';
        $datetime = date('Y-m-d H:i:s');
        $user_id = user()->id;
        $wheel_id = query("INSERT INTO wheels (user_id, name, datetime) VALUES('$user_id', '$name', '$datetime')");
        $sql = "INSERT INTO wheel_members (wheel_id, name, weight, color) VALUES " . join(',', array_map(function ($item) use ($wheel_id) {
            $weight = is_numeric($item['weight']) ? $item['weight'] : 1;
            return "($wheel_id, '{$item['name']}', '$weight', '{$item['color']}')";
        }, $_POST['item']));
        query($sql);
        response(['wheel_id' => $wheel_id]);exit;
    }
}
error("Method not allowed");
