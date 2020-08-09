<?php

    try {

        //Information de connection
        $username = 'SterDevs';
        $password = 'ster1402';
        $dbname = 'SiteWebDB';
        $host = 'localhost';
        $dsn = 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';

        $conn = new PDO($dsn,$username,$password,[PDO::ATTR_PERSISTENT => true ]);

        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $error ) {
        die("Erreur : ".$error->getMessage());
    }