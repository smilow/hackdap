<div id="mainContent">
	<div class="container">

		<iframe src="http://a.tiles.mapbox.com/v3/rmurby.map-cfz7czwh.html#4.00/32.39/-90.98" style="height:400px;width:100%; border:0; margin-bottom:10px;"></iframe>
<?
echo('Please select a disaster below.');
echo('<ul>');
foreach($this->disasters as $disaster) {
	echo('<li><a href="'.$disaster->get_path().'">'.$disaster->name_disaster.'</a></li>');
}
echo('</ul>');
?>
	</div>
</div>