<?php
/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 19.04.2017
 * Time: 9:05
 */
class session
{//Klassi algus
    //Klassi muutujad
    var $sid = false; //Sessiooni  id
    var $vars = array(); //Sessiooni ajal tekkivad andmed
    var $http = false; //objekt veebiandmete kasutamiseks
    var $db = false; //objekt andmebaasi kasutamiseks
    //Kui anonüümne lubatud ei ole - var $anonymous = false;
    var $anonymous = true; //anonüümne kasutaja on lubatud
    // sessiooni pikkus
    var $timeout = 60; // 1 minutit
    //Klassi muutujad lõpp
    //Konstruktor algus
    function __construct(&$http, &$db){
        $this->http = &$http;
        $this->db = &$db;
        //Võtame sessiooni id andmed
        $this->sid = $http->get('sid');
        $this->checkSession();
    }//Konstruktor lõpp
    //Sessiooni loomine algus.
    function createSession($user = false){
        //Kui kasutaja on anonüüme
        if($user == false){
            //Tekitame andmed session tabeli jaoks - algus
            $user = array(
                'user_id' => 0,
                'role_id' => 0,
                'username' => 'Anonymous'
            );
        }//Anonüümne kasutaja lõpp
        //Unikaalse sessiooni id loomine
        $sid = md5(uniqid(time().mt_rand(1, 1000), true));
        //päring sessiooni andmete salvestamiseks andmebaasi
        $sql ='INSERT INTO session SET '.
            'sid='.fixDb($sid).', '.
            'user_id='.fixDb($user['user_id']).', '.
            'user_data='.fixDb(serialize($user)).', '.
            'login_ip='.fixDb(REMOTE_ADDR).', '.
            'created=NOW()';
        //Sisestame päringu andmebaasi
        $this->db->query($sql);
        //määrame sid ka antud klassi muutujale var $sid
        $this->sid =$sid;
        //paneme antud väärtuse ka veebi - lehtede vahel kasutamiseks
        $this->http->set('sid', $sid);
    }//Sessiooni loomine lõpp
    //Sessiooni tabeli puhastamine algus
    function clearSessions(){
        $sql = 'DELETE FROM session WHERE '.
            time().' - UNIX_TIMESTAMP(changed) > '.
            $this->timeout;
        $this->db->query($sql);
    }//Sessiooni tabeli puhastamine lõpp
    //Sessiooni kontroll algus
    function checkSession(){
        $this->clearSessions();
        //Kui sid on puudu ja anonüümne on lubatud
        //tekitame alustamiseks anonüümse sessiooni
        if($this->sid === false and $this->anonymous){
            $this->createSession();
        }
        //juhul kui sid on olemas
        if($this->sid !== false){
            //Võtame andmed sessiooni tabelist, mis on antud id'ga seotud
            $sql = 'SELECT * FROM session WHERE '.
                'sid='.fixDb($this->sid);
            //saadame päringu andmebaasi ja võtame andmed
            $res = $this->db->getArray($sql);
            //Kui andmebaasist andmeid ei tule
            if($res == false){
                //Kui anonüümne on lubatud
                //Siis loome uue sessiooni
                if($this->anonymous){
                    $this->createSession();
                } else {
                    //Kui anonüümne sessioon ei ole lubatud, siis tuleb kustutada kõik antud sessiooniga
                    //seotud andmed veebist
                    $this->sid = false;
                    $this->http->del('sid');
                }
                //Lisame anonüümse kasutaja rolli ja id
                define('ROLE_ID', 0);
                define('USER_ID', 0);
            } else {
                //Kui andmebaasist on võimalik sessiooni kohta andmeid saada
                //Kõigepealt sessiooni andmed
                $vars = unserialize($res[0]['svars']);
                if(!is_array($vars)){
                    $vars = array();
                }
                $this->vars = $vars;
                //nüüd kasutaja andmed
                $user_data = unserialize($res[0]['user_data']);
                define('ROLE_ID', $user_data['role_id']);
                define('USER_ID', $user_data['user_id']);
                $this->user_data = $user_data;
            }
        } else {
            //Kui $this->id = false
            //hetkel sessiooni pole
          //  echo 'Sessiooni hetkel ei ole';
            define('ROLE_ID', 0);
            define('USER_ID', 0);
        }
    }//Sessiooni kontroll lõpp
    
    //Sessiooni uuendamine
    function flush(){
        if($this->sid !== false){
            $sql = 'UPDATE session SET changed=NOW(), '.
                'svars='.fixDb(serialize($this->vars)).
                ' WHERE sid='.fixDb($this->sid);
            $this->db->query($sql);
        }
    }
    //Sessiooni andmete lisamine algus
    function set($name, $val){
        $this->vars[$name] = $val;
    }//Sessiooni andmete lisamine lõpp
    //Sessiooni andmete võtmine algus
    function get($name, $val){
        if(isset($this->vars[$name])){
            return $this->vars[$name];
        }
        return false;
    }//Sessiooni andmete võtmine lõpp
    //DEL algus
    function del($name){
        if(isset($this->vars[$name])){
            unset($this->vars[$name]);
        }
    }//DEL lõpp
    //Sessiooni kustutamine algus
    function delsession(){
        if($this->sid != false){
            $sql = 'DELETE FROM session '.
                'WHERE sid='.fixDb($this->sid);
            $this->db->query($sql);
            $this->sid = false;
            $this->http->del('sid');
        }
    }// Sessiooni kustutamine lõpp
}//Klassi lõpp
