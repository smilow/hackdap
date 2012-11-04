<?
header("HTTP/1.1 301 Moved Permanently");
header('Location: http://www.disasteraccountability.org/dcweek/landing-email.php');
die();

require_once('_config.php');
$page = new page();
$page->redirect('http://www.disasteraccountability.org/dcweek/disaster.php');
