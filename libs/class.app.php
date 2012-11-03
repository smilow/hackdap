<?
class app {
	function start() {
		session_set_cookie_params((60*60*24-1));
		session_start();
		set_time_limit(5);
		error_reporting(E_ALL ^ E_NOTICE);
		if (!defined(PATH))
			define('PATH', dirname(__FILE__).'/../');
		if (!defined(TEMPLATES))
			define('TEMPLATES', PATH.'/templates');
		if (!defined(CACHE))
			define('CACHE', PATH.'/pub/cache');
		if ($handle = opendir(LIBS)) {
			require_once(LIBS.'/class.container.php');
			require_once(LIBS.'/class.dbo.php');
		    require_once(LIBS.'/class.page.php');
		    while (false !== ($file = readdir($handle))) {
		    	if (!in_array($file, array('.', '..'))) {
					require_once(LIBS.'/'.$file);
		//			echo('dynamically loading: '.$file.'<br>');
				}
		    }
		    closedir($handle);
		} else {
			die('<b>Fatal Error</b>: couldn\'t load libraries from main include path.');
		}
		$GLOBALS['db'] = new mysqldb(DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_HOST);
	}
	
	function get_table_keys($table) {
		if (!isset($GLOBALS['table_keys'][$table])) {
			global $db;
			$res = $db->query("describe `".addslashes($table)."`");
			$keys = array();
			while ($row = $db->fetch_array($res)) {
				$keys[] = $row['Field'];
			}
			$GLOBALS['table_keys'][$table] = $keys;
		}
		return $GLOBALS['table_keys'][$table];
	}

}
