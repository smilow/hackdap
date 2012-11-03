<?
class disaster extends dbo {
	
	function get_path() {
		return '/dcweek/disaster.php?id='.$this->id;
	}
	
	static function load_by_query($query) {
		/* this is a dirty hack.  this function should be in the parent but the server doesn't support get_called_class() because the version number is too low */
		
		global $db;
//		$type = get_called_class();
		$type = self::get_type();
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
	
	function get_type() {
		return 'disaster';
	}

	function load_by_id($id) {
		$disaster = disaster::load_by_query("select * from disasters where id = '".addslashes($id)."' limit 1");;
		return $disaster;
	}

}
