<?
class relief extends dbo {
	
	function insert() {
		global $db;
		$this->boots = array();
		$this->services = array();
		foreach($this as $key => $value) {
			if (strpos($key, '-') !== false) {
				list($field, $subfield, $hash) = explode('-', $key);
				if (($field == 'boot') && ($subfield == 'type') && ($value != 'Enter or Select Boot Type')) {
					$count_key = 'boot-count-'.$hash;
					if (($this->$count_key != 'Enter the Boot Count') && ($this->$count_key > 0))
						$this->boots[$value] += $this->$count_key;
				} else if (($field == 'service') && ($value != 'Enter or Select a Service') && ($value != '')) {
					$this->services[] = $value;
				}
			}
		}
		
		
		if (isset($this->name_organization) && ($this->name_organization != 'Enter or Select an Organization Name')) {
			$this->organization = organization::load_by_name($this->name_organization);
			if (!is_numeric($this->organization->id)) {
				$this->organization->name_organization = $this->name_organization;
				$this->organization->insert();
			}
		}
		if (isset($this->name_disaster) && ($this->name_disaster != 'Enter or Select a Disaster')) {
			$this->disaster = disaster::load_by_name($this->name_disaster);
			if (!is_numeric($this->disaster->id)) {
				$this->disaster = new disaster();
				$this->disaster->name_disaster = $this->name_disaster;
				$this->disaster->insert();
			}
		}
		
//		$this->money_raised = cleaner::strip_to_chars($this->money_raised, '0123456789.');
//		$this->money_spent = cleaner::strip_to_chars($this->money_spent, '0123456789.');
		
		$this->id = $db->query("insert into disasters_organizations values (''
			, '".addslashes($this->organization->id)."'
			, '".addslashes($this->disaster->id)."'
			, '".addslashes($this->money_raised)."'
			, '".addslashes($this->money_spent)."'
			, '".addslashes($this->currently_soliciting)."'
			, '".addslashes($this->crisis_mission)."'
			, '".addslashes($this->operating_there_start)."'
			, '".addslashes($this->onground_ops)."'
			, '".addslashes($this->resp_start_date)."'
			, '".addslashes($this->resp_end_date)."'
			, '".addslashes($this->donation_interest_raised)."'
			, '".addslashes($this->interest_allocation)."'
			, '".addslashes($this->locally_hired_staff)."'
			, '".addslashes($this->expected_outcomes)."'
			, '".addslashes($this->benchmark_achievements)."'
			, '".addslashes($this->strengths_weaknesses)."'
			, '".addslashes($this->reported_collaborations)."'
			, '".addslashes($this->govt_registration)."'
			, '".addslashes($this->disaster_contact_info)."'
			, now()
		)"); 
		
		foreach($this->boots as $type => $count) {
			$db->query("insert into people_helping values ('', '".addslashes($this->id)."', '".addslashes($count)."', '".addslashes($type)."')");
		}
		
		foreach($this->services as $service) {
			$service_id = $db->fetch_var("select id from services where name_service = '".addslashes($service)."' limit 1");
			if ($service_id < 1) {
				$service_id = $db->query("insert ignore into services values ('', '".addslashes($service)."', now())");
			}
			$db->query("insert into services_provided values ('', '".addslashes($this->id)."', '".addslashes($service_id)."')");
		}
	}
}