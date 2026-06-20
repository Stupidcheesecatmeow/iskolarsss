<?php

require "db.php";

$result = $db->query("PRAGMA table_info(attendance)");

echo "<pre>";

foreach($result as $row){
    print_r($row);
}

echo "</pre>";