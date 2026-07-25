<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS simpeg_sp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
    echo "DB_SUCCESS: Database simpeg_sp created or already exists.\n";
} catch (\Throwable $e) {
    echo "DB_ERROR: " . $e->getMessage() . "\n";
}
