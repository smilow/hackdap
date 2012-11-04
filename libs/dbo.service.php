<?
class service extends dbo {
	function get_service_names() {
		global $db;
		return $db->fetch_list("select distinct trim(name_service) from services where trim(name_service) != '' order by name_service asc");
	}
	
}
