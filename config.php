<?php

    try {
        $pdo = new PDO("mysql:host=localhost;port=4000;dbname=db_exam", "root", "");
        session_start();
    }catch(Exception $ex) {
        die("DB connectoin not established");
    }
