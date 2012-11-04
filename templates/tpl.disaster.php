<div id="mainContent">
	<div class="container">
		<!-- main content start -->
		
		<div class="row-fluid">
			<div class="span12">
<?
echo('
	<h1>'.$this->disaster->name_disaster.'</h1>
	<div class="disaster_summary">'.nl2br($this->disaster->summary_disaster).'</div>
	<div class="disaster_overview">
		<div class="row-fluid">
			<div class="span4">
				<div id="money-raised">
					Money Raised
					<div class="number">$'.number_format($this->disaster->get_money_raised()).'</div>
				</div>
				<div id="burn-rate">
					Burn Rate
					<div class="number">'.$this->disaster->get_burn_rate().'%</div>
				</div>
				<div class="donate">
					<a class="btn btn-large btn-success" href="#">Donate</a>
				</div>
			</div>
			<div class="span4">
				<div id="boots-on-ground">
					Boots on the Ground
					<div class="number">'.$this->disaster->get_total_people().'</div>
				</div>
			</div>
			<div class="span4">
				<div id="services">
					<b>Services Provided</b>
					
');
foreach($this->disaster->get_services() as $service) {
	echo('<div class="service-items"><i class="sprite-icon '.str::slug($service).'"></i><span>'.$service.'</span></div>');
}
echo('
					
				</div>
			</div>
		</div>
	</div>
	<table cellpadding=3 class="table table-striped table-bordered">
');

$i = 0;
foreach($this->organizations as $organization) {
	if ($i++ % 10 == 0) {
		echo('
			<tr>
				<th width="30%">Organization</th>
				<th width="13%">Money Raised</th>
				<th width="10%">Burn Rate</th>
				<th width="22%">People Helping</th>
				<th width="25%">Services Provided</th>
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
	echo('</td><td>');
	$i = 0;
	foreach($organization->get_services_in_disaster($this->disaster->id) as $service) {
		if ($i++ > 0)
			echo(', ');
		echo('<span class="'.str::slug($service).'">'.$service.'</span>');
	}
	echo('</td>
		</tr>
	');
}

echo('</table>');
?>
				
			</div>
		</div>

		
	</div><!-- main content end -->
</div>
