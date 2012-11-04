<?
class survey extends dbo {
	
	function load_by_key($key) {
//		$survey = 
	}
	
	function insert() {
		global $db;
		$this->db->query("insert into surveys values('',
			, '".addslashes($this->organization_id)."'
			, '".addslashes($this->json_values)."'
		)");
	}
	
}
