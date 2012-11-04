<?
require_once('_config.php');
$page = new page();
//$visitor = user::session_load();

if (isset($_POST['submitted'])) {
	$relief = new relief($_POST);
	$relief->insert();
}

$page->disaster_names = disaster::get_disaster_names();
$page->boots = people::get_boot_types();
$page->services = service::get_service_names();
$page->css[] = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery.ui.all.css';


$page->render('tpl.survey.php');
