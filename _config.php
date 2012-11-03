<?
define('DATABASE_USERNAME', 'disastg1_dapuser');
define('DATABASE_PASSWORD', '1q2w3e4r');
define('DATABASE_NAME', 'disastg1_dap');
define('DATABASE_HOST', 'localhost');

define('PASSWORD_SEED', '49jfiwnf48');

define('DATE_TIME_MASK', 'F j, Y @ g:i A'); 
define('DATE_MASK', 'F j, Y'); 
define('DATE_MASK_NUMERIC', 'n/j/Y'); 
define('TIME_MASK', 'g:i A'); 

define('PATH', dirname(__FILE__));
define('LIBS', PATH.'/libs');

define('SITE_NAME', 'Disaster Accountability Project');
define('SITE_HOST', 'www.disasteraccountabilityproject.com');

define('DEVELOPER_KEY', 'devkey123');
define('DEVELOPER_COOLDOWN', 60*60*24);
define('ADMIN_KEY', DEVELOPER_KEY);

require_once(LIBS.'/class.app.php');
app::start();