<?php require_once '../script/includes/start.php';
// header('Content-Type: application/json');

$available_resorces = ['app_user', 'wheels'];
$resource = isset($_GET['resource']) ? $_GET['resource'] : "";
$argument = isset($_GET['argument']) ? $_GET['argument'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";
$data = isset($_GET['data']) ? $_GET['data'] : "";

if(!$resource || !in_array($resource, $available_resorces)){
    echo json_encode(['status' => 0, 'msg' => 'invalid resource. try to use: '. join(', ',$available_resorces)]); exit;
}

if($resource == 'wheels'){
    switch ($argument){
        case '': get_all_wheels(); break;
        case 'get': get_wheel($id); break;
        case 'store': add_wheel($data); break;
        case 'update': edit_wheel($id, $data); break;
        case 'delete': delete_wheel($id); break;
        case 'winner': winner($id); break;
    }
}

if($resource == 'app_user'){
    switch ($argument){
        case 'register': echo json_encode(['status' => 1, 'data' => app_user()]); exit; break;
    }
}


function get_all_wheels(){
    $user = app_user(); $wheels = query("SELECT * FROM wheels WHERE user_id = '$user->id'");
    if($wheels){
        $items = query("SELECT * FROM wheel_members WHERE wheel_id IN (".join(',', array_column($wheels, 'id')).")");
        foreach($wheels as $key => $wheel){
            $wheels[$key]->items = array_values(array_filter($items, function($item)use($wheel){return $item->wheel_id == $wheel->id;}));
        }
    }
    echo json_encode(['status' => 1, 'data' => $wheels]); exit;
}
function get_wheel($id){
    $selected_wheel = query("SELECT * FROM wheels WHERE id = '$id'");
    if($selected_wheel){
        $selected_wheel[0]->items = query("SELECT * FROM wheel_members WHERE wheel_id = '$id'");
        echo json_encode(['status' => 1, 'data' => $selected_wheel[0]]); exit;
    }
    echo json_encode(['status' => 0, 'msg' => 'wheel not found']); exit;
}
function add_wheel($data){
    $inputs = json_decode($data);
    $name = trim($inputs->name);
    $name = $name ? $name : 'Wheel';
    $datetime = date('Y-m-d H:i:s');
    $user_id = app_user()->id;
    $wheel_id = query("INSERT INTO wheels (user_id, name, datetime) VALUES('$user_id', '$name', '$datetime')");
    $sql = "INSERT INTO wheel_members (wheel_id, name, weight, color) VALUES " . join(',', array_map(function ($item) use ($wheel_id) {
        $weight = is_numeric($item->weight) ? $item->weight : 1;
        return "($wheel_id, '$item->name', '$weight', '{$item->color}')";
    }, $inputs->items));
    query($sql);
    get_wheel($wheel_id);
}
function edit_wheel($id, $data){
    $inputs = json_decode($data); 
    $wheel_id = $id;
    $name = trim($inputs->name);
    $name = $name ? $name : 'Wheel';
    $datetime = date('Y-m-d H:i:s');
    $user_id = app_user()->id;
    query("UPDATE wheels SET user_id = '$user_id', name = '$name', datetime = '$datetime' WHERE id = '$wheel_id'");
    query("DELETE FROM wheel_members WHERE wheel_id = $wheel_id");
    $sql = "INSERT INTO wheel_members (wheel_id, name, weight, color) VALUES " . join(',', array_map(function ($item) use ($wheel_id) {
        $weight = is_numeric($item->weight) ? $item->weight : 1;
        return "($wheel_id, '$item->name', '$weight', '{$item->color}')";
    }, $inputs->items));
    query($sql);
    get_wheel($wheel_id);
}
function delete_wheel($id){
    $user = app_user();
    query("DELETE FROM wheels WHERE id = '$id' AND user_id = '$user->id'");
    echo json_encode(['status' => 1, 'msg' => 'deleted']); exit;
}
function winner($id){
    $selected_wheel = query("SELECT * FROM wheels WHERE id = '$id'");
    echo json_encode(['status' => 1, 'data' => !empty($selected_wheel[0]->winner) ? $selected_wheel[0]->winner : null]); exit;
}