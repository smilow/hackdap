<?
class organization extends dbo {
	
	function get_path() {
		return '/dcweek/organization.php?id='.$this->id;
	}
	
	function get_website() {
		if ((strpos($this->website_organization, 'http://') === 0) || (strpos($this->website_organization, 'https://') === 0) || ($this->website_organization != '')) 
			return $this->website_organization;
		return 'http://'.$this->website_organization;
	}
	
	function get_organization_path() {
		return $this->get_path();
	}
	
	function get_disaster_path($disaster_id) {
		return '/dcweek/disaster-organization.php?organization_id='.$this->id.'&disaster_id='.$disaster_id;
	}
	
	function get_type() {
		return 'organization';
	}
	
	function get_organization_names() {
		global $db;
		return $db->fetch_list("select distinct name_organization from organizations where trim(name_organization) != '' order by name_organization asc");
	}
	
	function get_services_in_disaster($disaster_id) {
		if (!is_array($this->services)) {
			global $db;
			$this->services = $db->fetch_list("select name_service from services, services_provided, disasters_organizations where disasters_organizations.disaster_id = '".addslashes($disaster_id)."' and organization_id = '".addslashes($this->id)."' and services.id = services_provided.service_id and disasters_organizations.id = services_provided.disasters_organizations_id order by name_service asc");
		}
		return $this->services;
	}
	
	function get_people_in_disaster($disaster_id) {
		if (!is_array($this->people)) {
			$this->people = array();
			global $db;
			$res = $db->query("select * from people_helping, disasters_organizations where disasters_organizations.disaster_id = '".addslashes($disaster_id)."' and organization_id = '".addslashes($this->id)."' and disasters_organizations.id = people_helping.disasters_organizations_id");
			while ($row = $db->fetch_array($res)) {
				$this->people[$row['people_type']] += $row['people_count'];
			}
		}
		return $this->people;
	}
	
	function get_spent_on_disaster($disaster_id) {
		if (!is_array($this->spent))
			$this->spent = array();
		if (!isset($this->spent[$disaster_id])) {
			global $db;
			$money_entries = $db->fetch_list("select money_spent from disasters_organizations where disaster_id = '".addslashes($disaster_id)."' and organization_id = '".addslashes($this->id)."'");
			$this->spent[$disaster_id] = disaster::extract_total_money($money_entries);
		}
		return $this->spent[$disaster_id];
	}
	
	function get_burn_rate($disaster_id) {
		if ($this->get_raised_from_disaster($disaster_id) == 0)
			return 0;
		return round($this->get_spent_on_disaster($disaster_id)/$this->get_raised_from_disaster($disaster_id), 2)*100;
	}
	
	function get_raised_from_disaster($disaster_id) {
		if (!is_array($this->raised)) {
			$this->raised = array();
		}
		if (!isset($this->spent[$disaster_id])) {
			global $db;
			$money_entries = $db->fetch_list("select money_raised from disasters_organizations where disaster_id = '".addslashes($disaster_id)."' and organization_id = '".addslashes($this->id)."'");
			$this->raised[$disaster_id] = disaster::extract_total_money($money_entries);
			if ($this->raised[$disaster_id] < $this->get_spent_on_disaster($disaster_id)) {
				$this->raised[$disaster_id] = $this->get_spent_on_disaster($disaster_id);
			}
		}
		return $this->raised[$disaster_id];
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
	
	function load_by_id($id) {
		$organization = organization::load_by_query("select * from organizations where id = '".addslashes($id)."' limit 1");
		return $organization;
	}
	
	function load_by_name($name) {
		$organization = organization::load_by_query("select * from organizations where name_organization = '".addslashes($name)."' limit 1");
		return $organization;
	}

	function insert() {
		global $db;
		$this->id = $db->query("insert into organizations values (''
			, '".addslashes($this->name_organization)."'
			, '".addslashes($this->summary_organization)."'
			, '".addslashes($this->mission_organization)."'
			, '".addslashes($this->website_organization)."'
			, '".addslashes($this->phone_no_organization)."'
			, '".addslashes($this->email_organization)."'
			, '".addslashes($this->annual_budget_organization)."'
			, '".addslashes($this->icon_organization)."'
			, '".addslashes($this->contact_street_add)."'
			, '".addslashes($this->contact_street_add_other)."'
			, '".addslashes($this->contact_state_id)."'
			, '".addslashes($this->contact_city)."'
			, '".addslashes($this->contact_zip)."'
			, '".addslashes($this->contact_country_id)."'
			, now()
		)"); 
	}
}