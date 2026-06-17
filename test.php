<?php

require "db.php";

$result = $db->query("
SELECT *
FROM activities
");

foreach($result as $row)
{
    echo $row['id'] . " - " . $row['name'] . "<br>";
}