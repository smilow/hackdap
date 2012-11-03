<?
require_once('_config.php');

$page = new page();
$db->verbose = true;
$page->organization = new organization();
if (is_numeric($_GET['id'])) {
	$page->organization = organization::load_by_query("select * from organizations where id = '".addslashes($_GET['id'])."' limit 1");
}
if (is_numeric($page->organization->id)) {
	$page->render('tpl.organization.php');
}
