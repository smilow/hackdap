<?
class people extends dbo {
	
	function get_boot_types() {
		global $db;
		return $db->fetch_list("select distinct trim(people_type) from people_helping where trim(people_type) != '' order by people_type asc");
	}
}	