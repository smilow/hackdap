<?
class dbo extends container {
	var $updates = array();
	
	function __construct($args = false) {
		if (is_array($args)) {
			parent::__construct($args);
		}
		global $db;
		$this->db = $db;
		return $this;
	}
	
	function has_key() {
		foreach($this->keys as $key) {
			if ($this->$key != '')
				return true;
		}
		return false;
	}

	
	function commit() {
		if (count($this->updates) > 0) {
			$query = "update `".$this->table."` set ";
			$first = true;
			foreach(app::get_table_keys($this->table) as $key) {
				if (isset($this->updates[$key])) {
					$value = $this->updates[$key];
					if (!$first) {
						$query .= ", ";
					}
					$query .= "`".$key."` = '".addslashes($value)."'";
					$first = false;
					$this->$key = $value;
				}
			}
			$query .= " where id = '".addslashes($this->id)."' limit 1";
			$this->db->query($query);
		}
	}
	
	function __toString() {
		$keys = array('name', 'title', 'body');
		foreach($keys as $key) {
			if ($this->$key != '')
				return $this->$key;
		}
		return false;
	}
	
	function delete() {
		$this->db->query("delete from `".$this->table."` where `id` = '".addslashes($this->id)."' limit 1");
	}

	static function load_by_query($query) {
		/* this is a dirty hack because the server is using <v5.3 and i cant use get_called_class() */
		
		global $db;
//		$type = get_called_class();
		$type = $this->type;
		if (substr($query, -7, 7) == 'limit 1') {
			$row = $db->fetch_row($query);
			$dbo = new $type($row);
			return $dbo;
		} else {
			$objects = array();
			$res = $db->query($query);
			while ($row = $db->fetch_array($res)) {
				$obj = new $type($row);
				$objects[] = $obj;
			}
			return $objects;
		}
	}
	
	function load_by_id($id) {
		$type = get_class($this);
		$row = $this->db->fetch_row("select * from `".$this->table."` where id = '".addslashes($id)."' limit 1");
		$obj = new $type($row);
		return $obj;
	}
	
	function load_random($count = 1) {
		$type = get_class($this);
		if (is_numeric($count) && ($count > 1)){
			$randoms = array();
			$res = $this->db->query("select * from `".$this->table."` order by rand() limit ".$count);
			while ($row = $this->db->fetch_array($res)) {
				$randoms[] = new $type($row);
			}
			return $randoms;
		} else {
			$row = $this->db->fetch_row("select * from `".$this->table."` order by rand() limit 1");
			$obj = new $type($row);
			return $obj;
		}
	}
	
	function get_defaults() {
		return array();
	}
	
}

