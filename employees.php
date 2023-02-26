<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Seznam zaměstnanců</title>
</head>
<body class="container">
<h1>Seznam zaměstnanců</h1>
<table class='table'>
    <?php
    include ("./inc/db_connect.inc.php");
    include ("./errors.php");

    $sort_key = $_GET["poradi"] ?? "";
    $table_head = "<tr><th>Jméno<a href='?poradi=prijmeni_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=prijmeni_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Místnost<a href='?poradi=nazev_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=nazev_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Telefon<a href='?poradi=telefon_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=telefon_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Pozice<a href='?poradi=pozice_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=pozice_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th></tr>";
    if($sort_key != "")
        $table_head = str_replace($sort_key . "'", $sort_key . "' class='sorted'", $table_head);
    echo $table_head;


    $order_value = NULL;
    $order_direction = NULL;

    $sort = explode("_", $sort_key);
    if (count($sort) == 2 ) {
        $sort_value = $sort[0];
        $sort_direction = $sort[1];

        switch ($sort_value) {
            case "prijmeni":
                $order_value = "name";
                break;
            case "nazev":
                $order_value = "room_name";
                break;
            case "telefon":
                $order_value = "phone";
                break;
            case "pozice":
                $order_value = "job";
                break;
        }

        switch ($sort_direction) {
            case "up":
                $order_direction = "asc";
                break;
            case "down":
                $order_direction = "desc";
                break;
        }
    }

    if($order_direction != NULL && $order_value != NULL) {
        $order_string = "ORDER BY " . $order_value . " " . $order_direction;
    }
    else $order_string = "";


    $list = getEmployees($order_string);
    //var_dump($list);
    foreach ($list as $employee) {
        echo "
                <tr>
                        <td><a href='employee.php?employeeId={$employee->employee_id}'>{$employee->name}</a></td>
                        <td>{$employee->room_name}</td>
                        <td>{$employee->phone}</td>
                        <td>{$employee->job}</td>
                </tr>
        ";
    }
    ?>

</table>
<a href='index.html'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Zpět</a>
</body>
</html>
