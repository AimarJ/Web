<?php
/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 22.03.2017
 * Time: 12:22
 */
class template
{//klassi algus
    // template klassi omadused - muutujad
    var $file = ''; // html malli faili nimi
    var $content = false; // html malli faili sisu
    var $vars = array();  // html vaade sisu - reaalsed väärtused
    // klassi tegevused - meetodid - funktsioonid

    // html malli faili lugemine
    function loadFile() {
        $f = $this->file; // lokaalne asendus
        // kontrollime mallide kausta olemasolu
        if(!is_dir(TMPL_DIR)) {
            echo 'Kataloogi '.TMPL_DIR.' ei ole leitud';
        }
    }
    
    // loeme sisu html malli failist

    //lisame alamkataloogid kasutusele
    $f = TMPL_DIR.str_replace('.', '/', )