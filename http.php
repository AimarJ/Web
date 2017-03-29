<?php
/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 29.03.2017
 * Time: 13:53
 */
// defineerime vajalikud konstandid
define('CLASSES_DIR', 'classes/'); //classes kataloogi nime konstant
define('TMPL_DIR', 'tmpl/'); //tmpl kataloogi nime konstant

//võtame kasutusele vajalikud failid
require_once CLASSES_DIR.'template.php';
require_once CLASSES_DIR.'http.php';

//loome vajalikud objektid projekti tööks
$http = new http();
$http->init();
//testime http objekti tööd
echo '<pre>';
print_r($http);
echo '</pre>';
?>