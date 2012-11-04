<?
require_once('_config.php');
$page = new page();

if (isset($_POST) && (count($_POST) > 0)) {
	$subscriber = new subscriber($_POST);
	if ($subscriber->validates()) {
		$subscriber->insert();
	}
	$page->thanks = true;
} 

$page->render('tpl.landing-email.php');
