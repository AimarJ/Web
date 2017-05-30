<?php
/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 29.03.2017
 * Time: 14:49
 */
function fixUrl($val){
    return urlencode($val);
}

function fixDb($val){
    return '"'.addslashes($val).'"';
}
?>