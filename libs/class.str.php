<?
class str {
	function br2nl($subject) {
		return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $subject);
	} 
	
	static public function slug($subject) {
		$base = strtolower(htmlspecialchars_decode($subject));
		$base = strip_tags($base);
		
        for($i = 0; $i < strlen($base); $i++) {
			if (strpos('abcdefghijklmnopqrstuvwxyz0123456789-', $base[$i]) === false)
            	$base[$i] = ' ';
        }
        $base = trim($base);
        $base = str_replace(' ', '-', $base);
        $old = '';
        while($old != $base) {
            $old = $base;
            $base = str_replace('--', '-', $base);
			$base = ltrim($base, '-');
			$base = rtrim($base, '-');
        }
        if (strlen($base) > 80)
			$base = trim(substr($base, 0, 80));
		if ($base == '')
			$base = 1;
		return $base;
	}
}
