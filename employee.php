<!DOCTYPE html>

<?php
include ("./inc/db_connect.inc.php");
include ("./errors.php");

$employee_id = filter_input(INPUT_GET, "employeeId", FILTER_VALIDATE_INT); // je input int?
if($employee_id === false) { //filter failed
    throw404();
}
else if ($employee_id === NULL) { //variable not set?
    throw400();
}
$employee = getEmployee($employee_id); //
if($employee === NULL) {
    throw404();
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Karta zaměstnance: <?=$employee->first_name?> <?=$employee->surname?></title>
</head>
<body class="container">


    <h1><?=$employee->first_name?> <?=$employee->surname?></h1>
    <table class='table'>
        <dl class='dl-horizontal'>
            <dt>Jméno</dt><dd><?=$employee->first_name?></dd>
            <dt>Příjmení</dt><dd><?=$employee->surname?></dd>
            <dt>Pozice</dt><dd><?=$employee->job?></dd>
            <dt>Mzda</dt><dd><?=$employee->wage?></dd>
            <dt>Místnost</dt><dd><a href="room.php?roomId=<?=$employee->room_id?>"><?=$employee->room_name?></a></dd>
            <dt>Klíče</dt>
            <?php
            foreach($employee->keys as $key) {
                echo "<dd><a href='room.php?roomId={$key->room_id}'>{$key->name}</a></dd>";
            }
            ?>
        </dl>

        <a href='employees.php'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Zpět na seznam zaměstnanců</a>

</table>
</body>
</html>
