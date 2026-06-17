<?php

require "db.php";

$result = $db->query("
PRAGMA table_info(attendance)
");

foreach($result as $row)
{
    echo $row['name'] . "<br>";
}