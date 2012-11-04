
<div class="landing-page">
	<div class="box-wrapper">
<?
	if ($this->thanks) {
		echo('
			Thanks for caring about accountability!  We\'ll keep you updated.
		');
	} else {
		echo('
			<h1 style="font-size:14pt;">Sign up for Project Updates</h1>
			<form method="post" action="'.$_SERVER['PHP_SELF'].'">
				<table cellpadding=3 border=0>
					<tr>
						<td>First Name</td>
						<td><input type="text" name="first_name" default="Enter your first name"></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type="text" name="last_name" default="Enter your last name"></td>
					</tr>
					<tr>
						<td>Email Address</td>
						<td><input type="text" name="email_address" default="Enter your email address"></td>
					</tr>
				</table>
				<div id="privacy">We will not sell or share your email address.</div>
				<input type="submit" value="Sign Up" class="btn btn-large btn-success">
			</form>
		');
	}
?>
	</div>
</div>
