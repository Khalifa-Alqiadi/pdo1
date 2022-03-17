<?php
include "header.php";
include "db.php";
$database = DB::getInstance();
echo "<div='container p-10'>";
$table = $_POST['table'];
$name = $_POST['name'];
$data = $_POST['data'];
echo $data;
$rows = $database->table($table)->select($name)->get();

foreach($rows as $row){
    echo "<div= class='card'>";
        echo "<div class='card-header'>";
            echo $row[$name];
        echo "</div>";
    echo "</div>";
}
echo "</div>";
?>