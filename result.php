<?php
include "header.php";
include "database.php";
$database = new Database();
echo "<div='container p-10'>";
$table = $_POST['table'];
$name = $_POST['name'];
$data = $_POST['data'];
echo $data;
$rows = $database->getAllTable($name, $table, "", '', "ItemID", "");

foreach($rows as $row){
    echo "<div= class='card'>";
        echo "<div class='card-header'>";
            echo $row[$name];
        echo "</div>";
    echo "</div>";
}
echo "</div>";
?>