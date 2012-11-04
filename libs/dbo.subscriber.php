<?
class subscriber extends dbo {
	
	function validates() {
		return true;
	}
	
	function insert() {
		global $db;
		$db->query("insert into subscribers values (''
			, '".addslashes($this->first_name)."'
			, '".addslashes($this->last_name)."'
			, '".addslashes($this->email_address)."'
		)");
	}
}
