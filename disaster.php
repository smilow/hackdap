<?
require_once('_config.php');

$page = new page();
$page->disaster = new disaster();
if (is_numeric($_GET['id'])) {
	$page->disaster = disaster::load_by_query("select * from disasters where id = '".addslashes($_GET['id'])."' limit 1");
}
if (is_numeric($page->disaster->id)) {
	$order_by = 'modified';
	$order_dir = 'desc';
	$page->organizations = organization::load_by_query("select organizations.* from organizations, disasters_organizations where disaster_id = '".addslashes($page->disaster->id)."' and disasters_organizations.organization_id = organizations.id order by ".$order_by.' '.$order_dir);
	$page->render('tpl.disaster.php');
}
$page->disasters = disaster::load_by_query("select * from disasters order by modified desc");
$page->render('tpl.disaster.404.php');
