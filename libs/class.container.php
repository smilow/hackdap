<?
class container {
	var $errors = array();
	var $warnings = array();
	
	function container($args = false) {
		$this->cast($args);
		return $this;
	}
	
	function json_encode() {
		$copy = $this;
		$unsets = array('warnings', 'errors', 'db');
		foreach($copy as $key => $value) {
			if (is_numeric($key) || in_array($key, $unsets))
				unset($copy->$key);
		}
		return json_encode($copy);
	}
	
	function cast($args = false) {
		if (is_array($args)) {
			foreach($args as $key => $value) {
				if (!is_numeric($key))
					$this->$key = stripslashes($value);
			}
		}
		return $this;
	}

	function keys($force = false) {
		if (!isset($this->keys) || $force) {
			$this->keys = array();
			foreach($this as $key => $value) {
				$this->keys[] = $key;
			}
			return $this->keys;
		}
	}
	
	function dump() {
		foreach($this as $key => $value) {
			echo('<p><b>'.$key.'</b>: '.$value.'</p>');
		}
	}
	
	function __set($property, $value) {
		if (method_exists($this, 'set_'.$property)) {
			$method = 'set_'.$property;
			$callers = debug_backtrace();
			if ($callers[1]['function'] != $method) {
				return $this->$method($value);
			}
		}
		return $this->$property = $value;
	}
	
	function __get($property) {
		if (method_exists($this, 'get_'.$property)) {
			$method = 'get_'.$property;
			return $this->$method();
		} else if (isset($this->$property)) {
			return $this->$property;
		}
		return false;
	}
	

}
