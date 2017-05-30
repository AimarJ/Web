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
    //Päringu teostus
    function query($sql){
        $res = mysqli_query($this->conn, $sql);
        if($res == false){
            echo 'Viga päringus!<br />';
            echo '<b>'.$sql.'</b><br />';
            echo mysqli_error($this->conn).'<br />';
            exit;
        }
        return $res;
    }//Päringu teostamise lõpp
    //Andmetega päringu teostamine
    function getArray($sql){
        $res = $this->query($sql);
        $data = array();
        while ($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        if(count($data) == 0){
            return false;
        }
        return $data;
    }//Andmete päringu teostuse lõpp
}//Klassi lõpp
?>
