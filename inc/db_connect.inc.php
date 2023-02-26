<?php
$inifile = parse_ini_file("config.ini");

$host = $inifile["db_host"];
$db = $inifile["db"];
$user = $inifile["user"];
$pass = $inifile["pass"];
$charset = $inifile["charset"];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

function getRooms($orderString) {
    global $pdo;
    $query = "select * from room " . $orderString . ";";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function getEmployees($orderString) {
    global $pdo;
    $query = "select employee_id, concat(surname, ' ', employee.name) as 'name', room.name as 'room_name', phone, job from employee join room on employee.room = room.room_id ". $orderString . ";";
    return $pdo->query($query)->fetchAll(PDO::FETCH_OBJ);
}

function getEmployee($employee_id) {
    global $pdo;
    $query = "select employee_id, surname, employee.name as 'first_name', room_id, room.name as 'room_name', wage, job from employee join room on employee.room = room.room_id where employee_id = {$employee_id};";
    $employee = $pdo -> query($query) -> fetch(PDO::FETCH_OBJ);
    if($employee === false)
        return NULL;
    $queryTwo = "select name, room_id from ip_3.key join room on ip_3.key.room=room.room_id where ip_3.key.employee = {$employee_id}";
    $keys = $pdo->query($queryTwo)->fetchAll(PDO::FETCH_OBJ);
    $employee->keys = $keys;
    return $employee;

}

function getRoom($room_id) {
    global $pdo;
    $query = "select room_id, no, room.name as 'room_name', phone from room where room_id = {$room_id};";
    $room = $pdo->query($query)->fetch(PDO::FETCH_OBJ);
    if($room === false)
        return NULL;

    $queryTwo = "select employee_id, concat(surname, ' ', left(employee.name, 1), '.') as 'name' from employee where room = {$room_id}";
    $people = $pdo->query($queryTwo)->fetchAll(PDO::FETCH_OBJ);
    $room->people = $people;

    $queryThree = "select avg(wage) as avg_wage from employee where room = {$room_id}";
    $wage = $pdo->query($queryThree)->fetch(PDO::FETCH_OBJ);
    if($wage === false) $room->wage = NULL;
    else $room->wage = $wage->avg_wage;

    $queryFour = "select employee_id, concat(surname, ' ', left(employee.name, 1), '.') as 'name' from ip_3.key join employee on ip_3.key.employee=employee.employee_id where ip_3.key.room={$room_id}";
    $keys = $pdo->query($queryFour)->fetchAll(PDO::FETCH_OBJ);
    $room->keys = $keys;

    return $room;
}


//include ("./inc/db_connect.inc.php");
//include ("./errors.php");
// write key like `key` or ip3.key
