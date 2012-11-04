<?
echo('
<div id="mainContent">
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<h1>'.$this->organization->name_organization.'</h1>
				<div class="disaster_summary">'.utf8_encode(nl2br($this->organization->summary_organization)).'</div>
			</div>
		</div>
		<div class="disaster_overview">
			<div class="row-fluid">
				<div class="span4">
					<div id="money-raised">
						Money Raised
						<div class="number">$'.number_format($this->organization->get_raised_from_disaster($this->disaster->id)).'</div>
					</div>
					<div id="burn-rate">
						Burn Rate
						<div class="number">'.$this->organization->get_burn_rate($this->disaster->id).'%</div>
					</div>
					<div class="donate">
						<a class="btn btn-large btn-success" href="#">Donate</a>
					</div>
				</div>
				<div class="span4">
					<div id="boots-on-ground">
						Boots on the Ground
						<div class="number">'.array_sum($this->organization->get_people_in_disaster($this->disaster->id)).'</div>
					</div>
				</div>
				<div class="span4">
					<div id="services">
						<b>Services Provided</b>
						
	');
	foreach($this->organization->get_services_in_disaster($this->disaster->id) as $service) {
		echo('<div class="service-items"><i class="sprite-icon '.str::slug($service).'"></i><span>'.$service.'</span></div>');
	}
	echo('
					
				</div>
			</div>
		</div>
	</div>
		<div class="row-fluid">
			<div class="span6">
				<div id="organization-stats">
					<h4>'.$this->disaster->name_disaster.' Specific Stats</h4>
					<ul>
						'.($this->relief->crisis_mission != '' ? '<li>Crisis Mission: <span>'.$this->relief->crisis_mission.'</li>' : '').'
						'.($this->relief->money_spent != '' ? '<li>Money Spent: <span>'.$this->relief->money_spent.'</li>' : '').'
						'.($this->relief->onground_ops != '' ? '<li>Staff on Ground: <span>'.$this->relief->onground_ops.'</li>' : '').'
						'.($this->relief->response_start_date != '' ? '<li>Response Start Date: <span>'.$this->relief->response_start_date.'</li>' : '').'
						'.($this->relief->response_end_date != '' ? '<li>Response End Date: <span>'.$this->relief->response_end_date.'</li>' : '').'
						'.(!in_array($this->relief->donation_interest_raised, array('', 'NR', 'N/A', 'N/A at this time.', 'No Response')) ? '<li>Interest raised on donations: <span>'.$this->relief->donation_interest_raised.'</li>' : '').'
						'.(!in_array($this->relief->interest_allocation, array('', 'NR', 'N/A', 'N/A at this time.', 'No Response')) ? '<li>Interest Allocation: <span>'.$this->relief->interest_allocation.'</li>' : '').'
						'.($this->relief->locally_hired_staff != '' ? '<li>Locally Hired Staff: <span>'.$this->relief->locally_hired_staff.'</li>' : '').'
						'.($this->relief->expected_outcomes != '' ? '<li>Expected Outcomes: <span>'.$this->relief->expected_outcomes.'</li>' : '').'
						'.($this->relief->benchmark_achievements != '' ? '<li>Achievements: <span>'.$this->relief->benchmark_achievements.'</li>' : '').'
						'.($this->relief->reported_collaborations != '' ? '<li>Collaborations: <span>'.$this->relief->reported_collaborations.'</li>' : '').'
						'.($this->relief->disaster_contact_info != '' ? '<li>Contact Information for particular disaster: <span>'.str_replace('@', ' at ', $this->relief->disaster_contact_info).'</li>' : '').'
						'.($this->relief->govt_registration > 0 ? '<li>Registered with government: <span>'.$this->relief->govt_registration.'</li>' : '').'
						
');

/*
 * soliciting donations
 * operation in location
 * history in crisis location
 * 
						'.($this->relief->strengths_weaknesses != '' ? '<li>Strengths and weaknesses: <span>'.$this->relief->strengths_weaknesses.'</li>' : '').'
						'.($this->disaster->money_spent != '' ? '<li>Operating in Crisis Location Since: <span>'.$this->disaster->crisis_mission.'</li>' : '').'
						'.($this->disaster->crisis_mission != '' ? '<li>History in Crisis Location: <span>'.$this->disaster->crisis_mission.'</li>' : '').'
						<li class="partner-org">Dollars Shared with Partner Organizations: 
							<ul>
								<li>Partner (<a href="#">Org</a>) - Amount: <span>$00.00</span></li>
								<li>Partner (<a href="#">Org</a>) - Amount: <span>$00.00</span></li>
								<li>Partner (<a href="#">Org</a>) - Amount: <span>$00.00</span></li>								
							</ul>
						</li>
*/
echo('
					</ul>
					<a href="'.$this->disaster->get_path().'">How are other organizations are helping out with this disaster?</a>
				</div>
			</div>
			<div class="span6">
				<div id="organization-background">
					<h4>'.$this->organization->name_organization.' Background</h4>
					<div class="organization_summary">'.$this->organization->summary_organization.'</div>
					<div class="organization_mission">
						<b>'.$this->organization->name_organization.' Mission</b>
						<p>'.$this->organization->mission_organization.'</p>
					</div>
					<div class="organization_contact_info">
');
/*
 * ein
 * fiscal year
 * guidestar url
 * charity navigator url
 */
if (($this->organization->email_organization != '') || ($this->organization->phone_no_organization > 0) || (strlen($this->organization->get_website() > 8))) {
	echo('
							<b>HQ Contact Information:</b>
							<address>
								'.($this->organization->contact_street_add != '' ? '<span class="street">'.$this->organization->contact_street_add.' '.$this->organization->contact_street_add_other.'</span>' : '').'
								'.($this->organization->contact_city != '' ? '<span class="city">'.$this->organization->contact_city.'</span>, <span class="zip">'.$this->organization->contact_zip.'</span>' : '').'
								'.($this->organization->phone_no_organization > 0 ? '<span class="phone">Phone: '.$this->organization->phone_no_organization.'</span>' : '').'
								'.($this->organization->email_organization != '' ? '<span class="email">Email: <a href="mailto:'.$this->organization->email_organization.'">'.$this->organization->email_organization.'</a></span>' : '').'
							</address>
							<span class="website"><a href="'.$this->organization->get_website().'" rel="nofollow">'.$this->organization->get_website().'</a></span>
	');
}
//	<!--						<span class="twitter">Follow us on Twitter <a href="#">@organization</a></span>-->
echo('
						'.($this->organization->annual_budget_organization != '' ? '<span class="overall-annual-budget">Overall Annual Budget: <b>'.$this->organization->annual_budget_organization.'</b></span>' : '').'
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

');
/*
$i = 0;
foreach($this->organizations as $organization) {
	if ($i++ % 10 == 0) {
		echo('
			<tr>
				<th>Organization</th>
				<th>Money Raised</th>
				<th>Burn Rate</th>
				<th>People Helping</th>
				<th>Services Provided</th>
			</tr>
		');
	}
	echo('
		<tr>
			<td><a href="'.$organization->get_disaster_path($this->disaster->id).'">'.$organization->name_organization.'</a></td>
			<td>$'.number_format($organization->get_raised_from_disaster($this->disaster->id)).'</td>
			<td>'.$organization->get_burn_rate($this->disaster->id).'%</td>
			<td>
	');
	if (count($organization->get_people_in_disaster($this->disaster->id)) > 0) {
		echo('<ul>');
		foreach($organization->get_people_in_disaster($this->disaster->id) as $people_type => $people_count) {
			echo('<li>'.$people_type.': '.$people_count.'</li>');
		}
		echo('</ul>');
	}
	echo('</td>
			<td>'.implode(', ', $organization->get_services_in_disaster($this->disaster->id)).'</td>
		</tr>
	');
}
echo('
			</table>
		</div>
	</div>
');
*/
