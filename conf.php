<?php
/**
 * Created by PhpStorm.
 * User: aimar.kauts
 * Date: 15.03.2017
 * Time: 15:25
 */
// defineerime vajalikud konstandid
define('CLASSES_DIR', 'classes/'); //classes kataloogi nime konstant
define('TMPL_DIR', 'tmpl/'); //tmpl kataloogi nime konstant
define('LIB_DIR', 'lib/') //lib kataloogi nime konstant

//võtame kasutusele vajalikud abifailid
require_once LIB_DIR.'utils.php';

//võtame kasutusele vajalikud failid
require_once CLASSES_DIR.'template.php';
require_once CLASSES_DIR.'http.php';
require_once CLASSES_DIR.'linkobject.php';

//loome vajalikud objektid projekti tööks
$http = new linkobject();
//testime linkobjecti tööd
echo $http->baseUrl;
echo '<pre>';
print_r
?>