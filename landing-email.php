<?
require_once('_config.php');
$page = new page();

if (isset($_POST) && (count($_POST) > 0)) {
	$db->verbose = true;
	$subscriber = new subscriber($_POST);
	if ($subscriber->validates()) {
		$subscriber->insert();
	}
} 

$page->render('tpl.landing-email.php');
