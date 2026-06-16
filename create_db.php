<?php

try {

    $db = new PDO("sqlite:attendance.db");

    $db->exec("
        CREATE TABLE IF NOT EXISTS activities (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS attendance (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            activity_id INTEGER,
            participant_id TEXT,
            attendance_date TEXT,
            attendance_time TEXT
        );
    ");

    echo "Database Created Successfully!";

} catch(PDOException $e) {
    echo $e->getMessage();
}