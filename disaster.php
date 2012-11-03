<?
require_once('_config.php');

$page = new page();
$page->disaster = disaster::load_by_query("select * from disasters");
$page->render('tpl.disaster.php');
