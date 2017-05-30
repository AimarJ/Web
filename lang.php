<?php
/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 14.05.2017
 * Time: 12:15
 */
// defineerime eraldaja template abil
$sep = new Template('lang.sep');
$sep = $sep->parse();
$count = 0;
// kõik keeled meil on konfis keelemassiivis kujul - et=>nimi
foreach ($siteLangs as $lang_id => $lang_name) {
    // suurendame keele eraldajate joonistamiseks
    $count++;
    // kui tegu on aktiivse keelega, kasutame aktiivset malli
    if($lang_id == LANG_ID){
        $item = new Template('lang.active');
    }
    // tavaline mall
    else{
        $item = new Template('lang.item');
    }
    // keelte vahel klopsamiseks oleks vaja tekitada link, mille sisse lähevad add massiivina keel, aie masiivina tegevus
    // menüü element, not massiivina keelevalik
    $link = $http->getLink(array('lang_id'=>$lang_id), array('act', 'page_id'), array('lang_id'));
    $item->set('link', $link);
    $item->set('name', $lang_name);
    $main_tmpl->add('lang_bar', $item->parse());
    // keele eraldamiseks paneme separaatori, aga viimase keele pärast me separaatorit ei pane
    if($count < count($siteLangs)){
        $main_tmpl->add('lang_bar', $sep);
    }
}
