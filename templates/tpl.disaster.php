<div id="mainContent">
	<div class="container">
		<!-- main content start -->
		
		<div class="row-fluid">
			<div class="span12">
<?
echo('
	<h1>'.$this->disaster->name_disaster.'</h1>
	<div class="disaster_summary">'.nl2br($this->disaster->summary_disaster).'</div>
	<div class="row-fluid">
		<div class="span4">
			<div id="money-spent">Money Spent</div>
			$'.number_format($this->disaster->get_money_spent()).'
		</div>
		<div class="span4">
			<div id="boots-on-ground">Boots on the Ground</div>
			'.$this->disaster->get_total_people().'
		</div>
		<div class="span4">
			<div id="services">Services Provided</div>
			'.implode(' ', $this->disaster->get_services()).'
		</div>
	</div>
	<table border=1 cellpadding=3>
');

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

echo('</table>');
?>
				
			</div>
		</div>

		
	</div><!-- main content end -->
</div>
