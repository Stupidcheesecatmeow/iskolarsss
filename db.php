<?php

try {

    $db = new PDO("sqlite:attendance.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Activities

    $db->exec("
        CREATE TABLE IF NOT EXISTS activities(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Attendance

    $db->exec("
    CREATE TABLE IF NOT EXISTS attendance (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        activity_id INTEGER,
        fullname TEXT,
        inb_number TEXT,
        cluster TEXT,
        attendance_date TEXT,
        time_in TEXT,
        time_out TEXT
    );
");

} catch(PDOException $e){

    die($e->getMessage());

}