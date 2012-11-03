<?
class mysqldb {
	function mysqldb($username, $password, $db_name, $host) {
		$this->db_name = $db_name;
		$this->host = $host;
		$this->username = $username;
		$this->commit = true;
		if ($_GET['show_query'] == 'false') {
			unset($_SESSION[show_query]);
			$this->verbose = false;
		}
		if (($_GET['show_query'] == 'true') || ($_SESSION['show_query'])) {
			$_SESSION['show_query'] = true;
			if (isset($_SERVER['HTTP_HOST']))
				$this->verbose = 'html';
			else
				$this->verbose = 'cl';
		}
		$this->link = mysql_connect($host, $username, $password) or die("Error: unable to connect to database (Database.connect)");
		if (!mysql_select_db($db_name)) {
			echo('Unable to select database('.$db_name.')'.mysql_error());
			exit();		
		}
		$this->query_count = 0;
		$this->open = true;
	}

	function query($query) {
		if ($this->verbose || !$this->commit) {
			if ($this->verbose == 'cl')
				echo("\nquery = ");
			else
				echo("\n<br><b>db=&gt;query</b>: ");
			echo($query);
//			if ($query[0] == 'u');
//				die($query);
			$this->query_count++;
			$first_word = substr($query, 0, strpos($query, ' '));
			if ($this->commit || !in_array($first_word, array('insert', 'update', 'delete'))) 
				$results = mysql_query($query, $this->link) OR die(mysql_error());
			if ($first_word == 'insert') {
				$id = mysql_insert_id();
				echo(' // id='.$id);
				return $id;
			} else if (($first_word == 'update') || ($first_word == 'delete')) {
				$aff = mysql_affected_rows();
				if ($aff > 0)
					echo(' // aff='.$aff);
				else
					echo(' // no affected rows');
				$results = $aff;
			} else if ($first_word == 'select') {
				echo(' // retrieved='.$this->num_rows($results));
			}
			echo("\n");		
			if ($this->verbose == 'html')
				echo('<br>');		
			return $results;
		} else {
			$results = mysql_query($query, $this->link) OR die(mysql_error());
			$this->query_count++;
			$first_word = substr($query, 0, strpos($query, ' '));
			if ($first_word == 'insert') {
				return mysql_insert_id();
			} else if (($first_word == 'update') || ($first_word == 'delete')) {
				return mysql_affected_rows();
			}
			return $results;
		}
	}

	function __set($property, $value) {
		if ($property == 'verbose') {
			if ($value === false)
				$this->verbose = false;
			else if ($value === true) {
				if (isset($_SERVER['HTTP_HOST']))
					$this->verbose = 'html';
				else
					$this->verbose = 'cl';
			} else {
				$this->verbose = $value;
			}
		} else {
			$this->$property = $value;
		}
		return $this;
	}

	
	function queries($queries) {
		foreach($queries as $query)
			$this->query($query);
	}
	
	function fetch_array($results) {
		$row = mysql_fetch_array($results);
		return $row;
	}

	function fetch_row($query) {
		$results = $this->query($query);
		$row = $this->fetch_array($results);
		return $row;
	}
	
	function fetch_list($query) {
		$results = $this->query($query);
		$list = array();
		while ($row = $this->fetch_array($results)) {
			$list[] = array_pop($row);
		}
		return $list;
	}
	
	function fetch_var($query) {
		$result = $this->fetch_row($query);
		if (is_array($result))
			return array_pop($result);
		return false;		
	}
	
	function insert_id() {
		return mysql_insert_id();
	}

	function num_rows($results) {
		$num_of_rows = mysql_num_rows($results);
		return $num_of_rows;
	}
	
	function close() {
		if ($this->open)
			mysql_close($this->link);
	}
	
	function find($needle) {
		echo('
			<div  style="font: 8pt arial, helvetica, verdana, tahoma, sans-serif; margin-bottom: 10px;">
			<p style="color: #006b00;">
				<b>db</b>: '.htmlspecialchars($this->db_name).'<br>
				<b>db host</b>: '.htmlspecialchars($this->host).'<br>
				<b>db username</b>: '.htmlspecialchars($this->username).'<br>
				<b>needle</b>: '.htmlspecialchars($needle).'<br>
			</p>
		');
		$tres = $this->query("show tables");
		while ($row = $this->fetch_array($tres)) {
			$table = $row[0];
			$res1 = $this->query("describe table `$table`");
			while($row = $this->fetch_array($res1)) {
				$field = $row['field'];
				$res = $this->query("select * from `$table` where locate('".$needle."', `".$field."`) != false limit 1");
				if ($this->num_rows($res) > 0)
					echo('<b>'.$table.'.'.$field.'</b>: <font color=red>found needle</font><br>');
				else
					echo('<b>'.$table.'.'.$field.'</b>: no needle<br>');
			}
		}
		echo('</div>');
	}

	function table_replace($search, $replace, $table) {
		$row = $this->fetch_row("select * from `".addslashes($table)."` limit 1");
		$keys = array_keys($row);
		foreach($keys as $key) {
			if (!is_numeric($key) && !is_numeric($row[$key])) {
				$res = $this->query("select * from `".addslashes($table)."` where locate('".addslashes($search)."', $key) != false");
				if ($this->num_rows($res) > 0) {
					echo('<b>'.$table.'.'.$key.'</b>: <font color=red>found needle</font><br>');
					while ($row1 = $this->fetch_array($res)) {
						$new = stripslashes(stripslashes(str_replace($search, $replace, $row1[$key])));
						$this->query("update `".addslashes($table)."` set $key = '".addslashes($new)."' where $key = '".addslashes($row1[$key])."'");
					}
				}
				else
					echo('<b>'.$table.'.'.$key.'</b>: no needle<br>');
			}
		}
	}
/*	
	function replace($search, $replace, $table = '') {
		echo('
			<div  style="font: 8pt arial, helvetica, verdana, tahoma, sans-serif; margin-bottom: 10px;">
			<p style="color: #006b00;">
				<b>db</b>: '.htmlspecialchars($this->db_name).'<br>
				<b>db host</b>: '.htmlspecialchars($this->host).'<br>
				<b>db username</b>: '.htmlspecialchars($this->username).'<br>
				<b>finding</b>: '.htmlspecialchars($search).'<br>
				<b>replacing with</b>: '.htmlspecialchars($replace).'<br>
			</p>
		');
		$tres = $this->query("show tables");
		while ($row = $this->fetch_array($tres)) {
			$table = $row[0];
		}
		echo('</div>');
	}
 */
}