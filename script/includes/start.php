<?php session_start();
date_default_timezone_set('Asia/kolkata');
function response($data){
    header('Content-type: application/json');
    echo json_encode(['success' => 1, 'data' => $data]);
}
function error($error){
    header('Content-type: application/json');
    echo json_encode(['success' => 0, 'error' => $error]);
}
function check_loged_in(){
    if(empty($_SESSION['loged_admin'])){
        header('Location: login.php');
        exit;
    }
}
function admin(){
    return !empty($_SESSION['loged_admin']) ? $_SESSION['loged_admin'] : NULL;
}
function query($sql = ""){
    $conn = new mysqli('localhost', 'root', '', 'spinningwheel');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if(is_bool($result)){
        $insert_id = $conn->insert_id;
        mysqli_close($conn);
        return $insert_id;
    }else{
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = (object)$row;
        }
        mysqli_close($conn);
        return $data;
    }
}
function user(){
    if(!isset($_COOKIE['__spinning_wheel_profile'])){
        $user = ['id' => '','name'=> 'User '. uniqid(), 'time' => time(), 'email' => ''];
        $datetime = date('Y-m-d H:s:i');
        if($id = query("INSERT INTO users (name, email, password, role, created_at) VALUES('{$user['name']}', '', '', 'user', '$datetime')")){
            $user['id'] = $id;
        }
        setcookie('__spinning_wheel_profile', base64_encode(json_encode($user)));
        return (object)$user;
    }else{
        return json_decode(base64_decode($_COOKIE['__spinning_wheel_profile']));
    }
}

function hslToHex($h, $s, $l) {
    // Normalize the inputs
    $h = $h % 360;
    $s = $s / 100;
    $l = $l / 100;

    $c = (1 - abs(2 * $l - 1)) * $s;
    $x = $c * (1 - abs(fmod(($h / 60), 2) - 1));
    $m = $l - $c / 2;

    $r = 0;
    $g = 0;
    $b = 0;

    if ($h < 60) {
        $r = $c;
        $g = $x;
        $b = 0;
    } elseif ($h < 120) {
        $r = $x;
        $g = $c;
        $b = 0;
    } elseif ($h < 180) {
        $r = 0;
        $g = $c;
        $b = $x;
    } elseif ($h < 240) {
        $r = 0;
        $g = $x;
        $b = $c;
    } elseif ($h < 300) {
        $r = $x;
        $g = 0;
        $b = $c;
    } else {
        $r = $c;
        $g = 0;
        $b = $x;
    }

    $r = round(($r + $m) * 255);
    $g = round(($g + $m) * 255);
    $b = round(($b + $m) * 255);

    // Convert to HEX
    $rHex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $gHex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $bHex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return "#" . $rHex . $gHex . $bHex;
}
