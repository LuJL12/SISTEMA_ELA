<?php

$host = 'localhost';
$user = 'root';
$db = 'bd_ieela';
$pass = '';

    try {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$user,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo 'ERROR: '.$e->getMessage();
    }