<?
class subscriber extends dbo {
	
	function validates() {
		if ((strpos($this->email_address, '@') !== false) || (strlen($this->email_address) < 6))
			$this->errors[] = 'Invalid email address';
		if (count($this->errors) > 0)
			return false;
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
