<?
require_once('_config.php');
$page = new page();
//$visitor = user::session_load();

if (isset($_POST['submitted'])) {
	$relief = new relief($_POST);
	$relief->insert();
}


$page->organization_names = organization::get_organization_names();
$page->disaster_names = disaster::get_disaster_names();
$page->boots = people::get_boot_types();
$page->services = service::get_service_names();
$page->boot_hash = md5(++$k + microtime());;
$page->css[] = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery.ui.all.css';

//$db->query("update people_helping set people_type = 'Resident/Citizen Staff' where people_type = 'Citizen/Resident Staff'");
$page->render('tpl.relief-edit.php');
