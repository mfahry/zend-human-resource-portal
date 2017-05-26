<?php
/*
* Last Edited By: Gundholmu vv
* 0:46 05/04/2010
*/  

session_start();
ob_start();         


# error reporting on
error_reporting(E_ALL);
if (!version_compare(phpversion(), '5.0', 'ge')) die('Minimum Modul Requirement PHP 5.0');

# mendefinisikan constant variable
define('SITE_PATH', (dirname(__FILE__)));
define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('JS_PATH', 'includes/js/');
define('CSS_PATH', 'includes/css/');
define('IMG_PATH', 'includes/img/');
define('JQUERY_PATH', 'includes/jquery/script');


define('JQUERY_JS_PATH', 'includes/jquery/ui/');
define('JQUERY_CSS_PATH', 'includes/jquery/themes/');
include 'config/init' . EXT;

# memuat router
$registry->router = new router($registry);

# set controller path
$registry->router->setPath (SITE_PATH . '/controller');

# memuat template
$registry->view = new views($registry);

# memuat controller
$registry->router->loader();

?>
