<?php
    $host = 'localhost';
    $db_name = 'db_moviestar';
    $user = 'root';
    $password = '';

    $conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);

    // Habilitar erros PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);