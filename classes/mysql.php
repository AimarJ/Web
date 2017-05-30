<?php

/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 5.04.2017
 * Time: 10:31
 */
class mysql
{ // klassi algus
    // klassi omadused
    var $conn = false; // ühendus andmebaasiserveriga
    var $host = false; // andmebaasi serveri host
    var $user = false; // andmebaasi serveri kasutaja
    var $pass = false; // andmebaasi serveri parool
    var $dbname = false; // andmebaasi serveris andmebaas

    // klassi tegevused
    function __construct($h, $u, $p, $dn){
        $this->host = $h;
        $this->user = $u;
        $this->pass = $p;
        $this->dbname = $dn;
        $this->connect();
    }// konstruktor

    function connect(){
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
        if(mysqli_connect_error()) {
            echo 'Viga andmebaasiserveriga ühenduses<br />';
            exit;
        }
    }// connect

}