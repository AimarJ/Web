<?php

/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 29.03.2017
 * Time: 14:22
 */
class linkobject extends http
{ //klassi algus
    //klassi muutujad - omadused
    var $baseUrl = false;
    var $delim = '&amp;';
    var $eq = '=';
    var $protocol = 'http://';

    var $aie = array('lang_id', 'sid'=>'sid'); // lisame keele näitamist veebis

    //klassi meetodid
    //klassi konstruktor
    function __construct(){
        parent::__construct(); //kutsume tööle http konstruktori
        //loome põhilingi
        $this->baseUrl = $this->protocol.HTTP_HOST.SCRIPT_NAME;
    } //konstruktor
    //andmete paari koostamine kujul
    //nimi=väärtus&nimi1=väärtus1 jne
    function addToLink(&$link, $name, $val){
        if($link != ''){
            $link = $link.$this->delim;
        }
        $link = $link.fixUrl($name).$this->eq.fixUrl($val);
    }// addToLink
    // saame täislink valmis
    function getLink($add = array(), $aie = array(), $not = array()){
        $link = '';
        foreach($add as $name=>$val){
            $this->addToLink($link, $name, $val);
        }
        // juhul, kui antud element juba meie lehel ette defineeritud
        foreach ($aie as $name){
            $val = $this->get($name);
            if($val != false){
                $this->addToLink($link, $name, $val);
            }
        }
        // juhul, kui antud objektis see väärtus juba määratud - näiteks keele id
        foreach ($this->aie as $name){
            $val = $this->get($name);
            // nüüd tuleb kontrollida, kas olemasolev asi juba lingis lisatud või mitte
            if($val != false and !in_array($name, $not)){
                $this->addToLink($link, $name, $val);
            }
        }
        if($link != ''){
            $link = $this->baseUrl.'?'.$link;
        } else {
            $link = $this->baseUrl;
        }
        return $link;
    }// getLink
}// klassi lõpp
