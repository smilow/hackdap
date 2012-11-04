<?
$this->javascript[] = '/dcweek/assets/js/main.js';
$this->javascript[] = '/dcweek/assets/js/relief.js';
echo('
	<script type="text/javascript">
		var disasters = ["'.implode('", "', $this->disaster_names).'"];
		var boots = ["'.implode('", "', $this->boots).'"];
		var services = ["'.implode('", "', $this->services).'"];
	</script>
	<style>
		td input {width:300px;}
	</style>

	<form method="post" action="'.$_SERVER['PHP_SELF'].'">
		<table border=0 cellpadding=3>
			<tr>
				<td>Organization:</td>
				<td><input type="text" class="combo" id="organization" name="name_organization" default="Enter or Select an Organization Name"></td>
			</tr>
			<tr>
				<td>Disaster: </td>
				<td><input type="text" class="combo" id="disaster" name="name_disaster" default="Enter or Select a Disaster"></td>
			</tr>
			<tr>
				<td>Money Raised: </td>
				<td><input type="text" id="money_raised" name="money_raised" default="Enter Money Raised in USD"></td>
			</tr>
			<tr>
				<td>Money Spent:</td>
				<td><input type="text" id="money_spent" name="money_spent" default="Enter Money Spent in USD"></td>
			</tr>
			<tr valign=top>
				<td>Boots (People) Involved:</td>
				<td>
					<div>
						<input type="text" class="boot-type" name="boot-type-'.$this->boot_hash.'" default="Enter or Select Boot Type">
						<input type="text" class="boot-count" name="boot-count-'.$this->boot_hash.'" default="Enter the Boot Count">
					</div>
				</td>
			</tr>
			<tr valign=top>
				<td>Services Provided:</td>
				<td>
					<input type="text" class="service" name="service-type-'.md5(++$k + microtime()).'" default="Enter or Select a Service">
				</td>
			</tr>
		</table>
		<input type="hidden" name="submitted" value="true">
		<input type="submit" value="Save">
	</form>
');

