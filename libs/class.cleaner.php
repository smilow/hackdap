<?

class cleaner {
	
	static function strip_to_chars($subject, $valid) {
		$stripped = '';
		for ($i = 0; $i < strlen($subject); $i++) {
			if (strpos($valid, $subject[$i]) !== false) {
				$stripped .= $subject[$i];
			}
		}
		return $stripped;
	}
	
	static function clean_email($subject) {
		$clean = strtolower($subject);
		$clean = self::strip_to_chars($clean, 'abcdefghijklmnopqrstuvwxyz1234567890@.+-_');
		return $clean;
	}
	
	function remove_iinner($left, $right, $subject, $replacement = '') {
		$parts = explode($left, $subject);
		if (count($parts) < 2)
			return $subject;
		foreach($parts as $key => $substring) {
			if ($key > 0) {
				$pos = stripos($substring, $right);
				if ($pos !== false) {
					$start = $pos + strlen($right);
					$parts[$key] = substr($substring, $start, strlen($substring) - $start);
				}
			}
		}
		$subject = implode($replacement, $parts);
		return $subject;
	}
	
	static function clean_phone($subject, $mask = '###-###-####') {
		$clean = $subject;
		$clean = self::strip_to_chars($clean, '1234567890');
		if ((strlen($clean) == 11) && ($clean[0] == '1'))
			$clean = substr($clean, 1, 10);
		if (strlen($clean) == 10) {
			$m = 0;
			$masked = '';
			for ($i = 0; $i < 10; $i++) {
				while (($mask[$m] != '#') && ($m < strlen($mask))) {
					$masked .= $mask[$m];
					$m++;
				}
				$masked .= $clean[$i];
				$m++;
			}
			$clean = $masked;
		}
		return $clean;
	}
	
	static function remove_fronts($subject, $removals) {
		if (!is_array($removals))
			$removals = array($removals);
		$cleaned = $subject;
		foreach($removals as $removal) {
			$length = strlen($removal);
			if (substr($cleaned, 0, $length) == $removal) {
				$cleaned = substr($cleaned, $length, strlen($subject) - $length);
			}
		}
		return $cleaned;
	}
	
	static function remove_backs($subject, $removals) {
		if (!is_array($removals))
			$removals = array($removals);
		$cleaned = $subject;
		foreach($removals as $removal) {
			$length = strlen($removal);
			if (substr($cleaned, $length * -1, $length) == $removal) {
				$cleaned = substr($cleaned, 0, $length * -1);
			}
		}
		return $cleaned;
	}
	
	function to_utf8($content) { 
	    if(!mb_check_encoding($content, 'UTF-8') 
	        OR !($content === mb_convert_encoding(mb_convert_encoding($content, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) { 
	        $content = mb_convert_encoding($content, 'UTF-8'); 
	    }
		return $content; 
	} 

	function show_ords($string) {
		echo("\n----showing ords for string[$string]----\n");
		for ($i = 0; $i < strlen($string); $i++) {
			echo('['.$string[$i].'] = '.ord($string[$i])."\n<br>");
		}
	}

	static function clean_website($subject) {
		$clean = $subject;
		$clean = self::to_utf8($clean);
		$from[] = 'http://http://';	$to[] = 'http://';
		$from[] = 'https://http://';	$to[] = 'https://';
		$from[] = 'http://https://';	$to[] = 'https://';
		$from[] = chr(194).chr(160);	$to[] = '';
		$clean = str_ireplace($from, $to, $clean);
//		$clean = self::remove_fronts($clean, array('https://', 'http://'));
		$clean = self::remove_backs($clean, array('index.html', 'index.htm', 'index.php', 'index.cfm', 'index.shtml', 'index.dhtml', 'index.asp', 'index.aspx', 'index.cgi'));
		$clean = trim($clean);
		if ((substr($clean, -1, 1) == '/') && (substr_count($clean, '/') == 1))
			$clean = substr($clean, 0, -1);
		$slashes = substr_count($clean, '/');
		if (($slashes == 0) || (($slashes == 2) && (strpos($clean, 'http://') !== false)) || (($slashes == 2) && (strpos($clean, 'https://') !== false))) {
			$clean = strtolower($clean);
		}
		return $clean;
	}
	
	static function extract_base_domain($subject) {
		$clean = $subject;
		$clean = strtolower($clean);
		$clean = self::clean_website($clean);
		$clean = self::remove_fronts($clean, array('http://', 'https://', 'www.'));
		$pos = strpos($clean, '/');
		if ($pos !== false) {
			$clean = substr($clean, 0, $pos);
		}
		$clean = self::strip_to_chars($clean, 'abcdefghijklmnopqrstuvwxyz0123456789-.');
		return $clean;
	}
	
	static function extract_email_address($subject) {
		$clean = strtolower(trim($subject));
		$at = strpos($clean, '@');
		if ($at === false)
			return '';
		$length = strlen($clean);
		$email = '@';
		for ($i = $at + 1; $i < $length; $i++) {
			if (strpos('abcdefghijklmnopqrstuvwxyz1234567890-.', $clean[$i]) !== false)
				$email .= $clean[$i];
			else
				break;
		}
		for($i = $at - 1; $i >= 0; $i--) {
			if (strpos('abcdefghijklmnopqrstuvwxyz1234567890-_+.', $clean[$i]) !== false)
				$email = $clean[$i].$email;
			else
				break;
		}
		return $email;
	}
	
	static function extract_email_domain($subject) {
		$clean = $subject;
		$clean = strtolower($subject);
		$pos = strpos($clean, '@');
		if ($pos === false)
			return '';
		$domain = substr($clean, $pos + 1, strlen($clean) - $pos);
		$end = strlen($domain);
		for ($i = 0; $i < $end; $i++) {
			if (strpos('abcdefghijklmnopqrstuvwxyz1234567890-.', $domain[$i]) === false) {
				$end = $i;
				$domain = substr($domain, 0, $end);
				$domain = rtrim($domain, '-.');
				break;
			} 
		}
		return $domain;
	}
	
	
	function remove_whitespace($subject) {
		$from[] = chr(0); $to[] = ' ';
		$from[] = chr(1); $to[] = ' ';
		$from[] = chr(2); $to[] = ' ';
		$from[] = chr(3); $to[] = ' ';
		$from[] = chr(4); $to[] = ' ';
		$from[] = chr(5); $to[] = ' ';
		$from[] = chr(6); $to[] = ' ';
		$from[] = chr(7); $to[] = ' ';
		$from[] = chr(8); $to[] = ' ';
		$from[] = chr(9); $to[] = ' ';
		$from[] = chr(10); $to[] = ' ';
		$from[] = chr(11); $to[] = ' ';
		$from[] = chr(12); $to[] = ' ';
		$from[] = chr(13); $to[] = ' ';
		$from[] = chr(14); $to[] = ' ';
		$from[] = chr(15); $to[] = ' ';
		$from[] = chr(16); $to[] = ' ';
		$from[] = chr(17); $to[] = ' ';
		$from[] = chr(18); $to[] = ' ';
		$from[] = chr(19); 	$to[] = ' ';
		$from[] = chr(20); $to[] = ' ';
		$from[] = chr(21); 	$to[] = ' ';
		$from[] = chr(22); $to[] = ' ';
		$from[] = chr(23); $to[] = ' ';
		$from[] = chr(24); $to[] = ' ';
		$from[] = chr(25); $to[] = ' ';
		$from[] = chr(26); $to[] = ' ';
		$from[] = chr(27); $to[] = ' ';
		$from[] = chr(28); $to[] = ' ';
		$from[] = chr(29); $to[] = ' ';
		$from[] = chr(30); $to[] = ' ';
		$from[] = chr(31); $to[] = ' ';
		$from[] = chr(32); $to[] = ' ';
		$from[] = '
';	$to[] = '';
		$from[] = "\r\n";	$to[] = '';
		$from[] = "\n\r";	$to[] = '';
		$from[] = "\r";	$to[] = '';
		$from[] = "\n";	$to[] = '';
		$from[] = '	';	$to[] = ' ';	//tab
		$from[] = '&nbsp;';	$to[] = ' ';
		$from[] = '        ';	$to[] = ' ';
		$from[] = '       ';	$to[] = ' ';
		$from[] = '      ';	$to[] = ' ';
		$from[] = '     ';	$to[] = ' ';
		$from[] = '    ';	$to[] = ' ';
		$from[] = '   ';	$to[] = ' ';
		$from[] = '  ';	$to[] = ' ';
		return trim(str_replace($from, $to, $subject));
	}
	
	static function main() {
		$phones = array('1234567890', '+1 848 939 9393', '555-888-3333', 'fjdsak (389)393 9999');
		foreach($phones as $phone) {
			echo("\nphone[$phone] cleaned[".self::clean_phone($phone)."]");
		}
	}

function strip_to_mask($string, $mask, $replacement = '') {
	$length = strlen($string);
	$new = '';
	for ($i = 0; $i < $length; $i++) {
		if (strpos($mask, $string[$i]) !== false)
			$new .= $string[$i];
		else
			$new .= $replacement;
	}
	return $new;
}

function strip_mask($subject, $mask, $replacement = '') {
	$length = $mask;
	for($i = 0; $i < $length; $i++) {
		$subject = trim(str_replace($mask[$i], $replacement, $subject));
	}
	return $subject;
}

function strip_to_single_spaces($string) {
	$from[] = '  ';	$to[] = ' ';
	$old = '';
	while ($string != $old) {
		$old = $string;
		$string = str_replace($from, $to, $string);
	}
	return $string;	
}



}
