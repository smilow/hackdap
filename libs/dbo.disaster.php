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
	
	function get_disaster_names() {
		global $db;
		return $db->fetch_list("select distinct trim(name_disaster) from disasters where trim(name_disaster) != '' order by name_disaster asc");
	}

	function load_by_id($id) {
		return self::load_by_query("select * from disasters where id = '".addslashes($id)."' limit 1");;
	}
	
	function load_by_name($name) {
		return self::load_by_query("select * from disasters where name_disaster = '".addslashes($name)."' limit 1");
	}
	
	function get_services() {
		if (!is_array($this->services)) {
			global $db;
			$this->services = $db->fetch_list("select distinct name_service from services, services_provided, disasters_organizations where disasters_organizations.disaster_id = '".addslashes($this->id)."' and services.id = services_provided.service_id and disasters_organizations.id = services_provided.disasters_organizations_id order by name_service asc");
		}
		return $this->services;
	}
	
	function get_people() {
		if (!is_array($this->people)) {
			$this->people = array();
			global $db;
			$res = $db->query("select * from people_helping, disasters_organizations where disasters_organizations.disaster_id = '".addslashes($this->id)."' and people_type not in ('Organization Staff') and disasters_organizations.id = people_helping.disasters_organizations_id");
			while ($row = $db->fetch_array($res)) {
				$this->people[$row['people_type']] += $row['people_count'];
			}
		}
		return $this->people;
	}
	
	function get_total_people() {
		if (!isset($this->total_people)) {
			$this->total_people = array_sum($this->people);
		}
		return $this->total_people;
	}
	
	function extract_total_money($money_entries) {
		/* dataset for money has a ton of extra commentary in it... just pull the fiscals and sum that */
		$total_cash = 0;
		foreach($money_entries as $money) {
			$parts = explode(' ', $money);
			foreach($parts as $part) {
				if (strpos($part, '$') !== false) {
					$cash = str_replace(array('$', ','), '', $part);
					$total_cash += $cash;
					break;
				}
			}
			if ((count($parts) == 1) && (strpos($money, '$') === false) && is_numeric(cleaner::strip_to_chars($money, '0123456789.'))) {
				$total_cash += cleaner::strip_to_chars($money, '0123456789.');
			}
		}
		return $total_cash;
	}
	
	function get_money_spent() {
		if (!isset($this->spent)) {
			global $db;
			$money_entries = $db->fetch_list("select money_spent from disasters_organizations where disaster_id = '".addslashes($this->id)."'");
			$this->spent = self::extract_total_money($money_entries);
		}
		return $this->spent;
	}
	
	function get_burn_rate() {
		if ($this->get_money_raised() == 0)
			return 0;
		return round($this->get_money_spent()/$this->get_money_raised(), 2)*100;
	}
	
	function get_money_raised() {
		if (!isset($this->raised)) {
			global $db;
			$money_entries = $db->fetch_list("select money_raised from disasters_organizations where disaster_id = '".addslashes($this->id)."'");
			$this->raised = self::extract_total_money($money_entries);
			if ($this->raised < $this->get_money_spent()) {
				$this->raised = $this->get_money_spent();
			}
		}
		return $this->raised;
	}
	
	function insert() {
		global $db;
		$this->id = $db->query("insert into disasters values (''
			, '".addslashes($this->name_disaster)."'
			, '".addslashes($this->summary_disaster)."'
			, '".addslashes($this->geo_lat_disaster)."'
			, '".addslashes($this->geo_lng_disaster)."'
			, '".addslashes($this->icon_disaster)."'
			, '".addslashes($this->messg_brd_disaster)."'
			, now()
		)");
		if ($this->id < 1) {
			$this->id = $db->insert_id();
			die('HAD TO INSERT');
		}
	}
}
