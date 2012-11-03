<?
echo('The disaster you requested could not be found.  Please select a disaster below.');

foreach($this->disasters as $disaster) {
	echo('<li><a href="'.$disaster->get_path().'">'.$disaster->name_disaster.'</a></li>');
}
