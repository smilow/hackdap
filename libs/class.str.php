<?
class str {
	function br2nl($subject) {
		return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $subject);
	} 
}
