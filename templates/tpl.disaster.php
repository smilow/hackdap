<?
echo('
	<h1>'.$this->disaster->name_disaster.'</h1>
	<div class="disaster_summary">'.$this->disaster->summary_disaster.'</div>
	<table border=1 cellpadding=3>
');

$i = 0;
foreach($this->organizations as $organization) {
	if ($i++ % 10 == 0) {
		echo('
			<tr>
				<th>Organizaiton</th>
				<th>Website</th>
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
			<td><a href="'.$organization->website_organization.'" rel="nofollow">'.$organization->website_organization.'</a></td>
			<td>$'.number_format($organization->get_raised_from_disaster($this->disaster->id)).'</td>
			<td>'.$organization->get_burn_rate($this->disaster->id).'%</td>
			<td>');
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

echo('</table>');
