<?php
/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 15.03.2017
 * Time: 13:08
 */
// võtame konfiguratsiooni kasutusele
require_once 'conf.php';
// pealehe sisu
echo '<h1>Veebiprogrammeerimise esileht</h1>';
// valmistame peatemplate objekti
$main_tmpl = new template('main');
// valmistame paarid malli_element => väärtus
$main_tmpl->set('user', $sess->user_data['username']);
$main_tmpl->set('title', tr('Pealeht'));
// lisame keeleriba pealehele
require_once 'lang.php';
$main_tmpl->set('menu', tr('Lehe peamenüü'));
// kutsume menüü tööle testimiseks
require_once 'menu.php';
// tõstsime vaikimisi väljund default tegevuse sisse
require_once 'act.php';
$main_tmpl->set('site_title', 'Veebiprogrammeerimise kursus');
// kontrollime antud objekti sisu
echo $main_tmpl->parse();
// uuendame sessiooni andmed
$sess->flush();
?>