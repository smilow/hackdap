<?
class page extends container {
	
	function __construct($args = false) {
		$this->keep_alive = false;
		$this->style = array();
		$this->css = array();
		$this->title = '';
		$this->javascript = array();
		$this->meta = array();
		$this->meta['content-type'] = 'http-equiv="Content-type" content="text/html;charset=UTF-8"';
		$this->header = 'tpl.header.php';
		$this->footer = 'tpl.footer.php';
		if (defined('DEFAULT_AUTHOR')) {
			$this->author = DEFAULT_AUTHOR;
		}
//		$this->cast($args);
		if (isset($this->central_object)) {
			$key = $this->central_object;
			if (is_array($args)) {
				$this->$key = new $key($args);
			} else if (is_object($args) && (get_class($args) == $this->central_object)) {
				$this->$key = $args;
			} else {
				$this->$key = new $key();
			}
		} else { 
			$this->central_object = 'page';
		}
	}

	function meta() {
		if (!isset($this->site_tag)) {
			if (defined(SITE_NAME))
				$this->site_tag = SITE_NAME;
			else if (defined(SITE_HOST))
				$this->site_tag = str_replace('www.', '', SITE_HOST);
			else
				$this->site_tag = str_replace('www.', '', $_SERVER['HTTP_HOST']);
		}
		echo('<title>'.$this->title);
		if ($this->site_tag != '') {
			if ($this->title == '') {
				echo($this->site_tag);
			} else if ($_SERVER['PHP_SELF'] != '/index.php') {
				echo(' | '.$this->site_tag);
			}
		}
		echo('</title>');

		if (!is_array($this->meta)) {
			die(__FILE__.'@'.__LINE__.': fatal error with non-array meta['.$this->meta.']');
		}
		foreach($this->meta as $meta) {
			echo('<meta '.$meta.' />');
		}
		if (!isset($this->meta['description'])) {
			if ($this->description != '') {
				echo('<meta name="description" content="'.htmlspecialchars($this->description).'"/>');			
			} else if ($site->description != '') {
				echo('<meta name="description" content="'.htmlspecialchars($site->description).'"/>');			
			}
		}
		if ($this->noindex && !isset($this->meta['noindex'])) {
			echo('<meta name="robots" content="noindex" />');
		}
		if ($this->author && !isset($this->meta['author'])) {
			echo('<meta name="author" content="'.htmlspecialchars($this->author).'">');
		}
		if ($this->canonical != '') {
			echo('<link rel="canonical" href="'.$this->canonical.'"/>');
		}
	}
	
	function javascript($key = false) {
		foreach($this->javascript as $js) {
			if (is_string($js) && (substr($js, -3, 3) == '.js')) {
				echo('<script type="text/javascript" src="'.$js.'"></script>');					
			} else if (is_array($js) && ($js['path'] != '')) {
				echo('<script type="text/javascript" src="'.$js['path'].'"></script>');
			} else if (is_array($js) && ($js['code'] != '')) {
				echo('<script type="text/javascript" language="javascript">'.$js['code'].'</script>');
			} else {
				echo('<script type="text/javascript" language="javascript">'.$js.'</script>');
			}				
		}
	}
	
	function css() {
		foreach($this->css as $css) {
			if (is_string($css))
				echo('<link rel="stylesheet" href="'.$css.'" type="text/css" />');
			else if (is_array($css) && isset($css['media']) && isset($css['path'])) {
				if (isset($css['if'])) {
					echo('<!--['.$css['if'].']>');
				}
				echo('<link rel="stylesheet" href="'.$css['path'].'" type="text/css" media="'.$css['media'].'"/>');
				if (isset($css['if'])) {
					echo('<![endif]-->');
				}
			}
		}
		if (count($this->style) > 0) {
			echo('<style>');
			foreach($this->style as $style) {
				echo($style);
			}
			echo('</style>');
		}
	}
	
	function redirect($target, $response = 302) {
		global $db;
		$db->close();
		if ($response == 301)
			header("HTTP/1.1 301 Moved Permanently");
		else if ($reponse == 302)
			header("HTTP/1.1 302 Moved Temporarily");
		else if ($response == 404)
			header("HTTP/1.1 404 Not Found");
		header('Location: '.$target);
		exit();
	}
	
	function close() {
		global $db;
		if (isset($db))
			$db->close();
		exit();
	}
	
	function render($template = false) {
		if ($template == 'tpl.404.php') {
			$this->fourofour = true;
		}
		if ($this->cache && (strpos($_SERVER['QUERY_STRING'], 'NOCACHE') === false)) {
			$cache = new cache();
			$cache->path = CACHE.'/'.$this->cache;
			$cache->start();
		} else {
			header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: pre-check=0, post-check=0, max-age=0');
			header('Pragma: no-cache'); 			
		}
		if ($this->fourofour) {
			header('HTTP/1.0 404 Not Found');
			$this->noindex = true;
		}
		if ($this->header != '')
			require(TEMPLATES.'/'.$this->header);
		require(TEMPLATES.'/'.$template);
		if ($this->footer != '')
			require(TEMPLATES.'/'.$this->footer);
		if ($this->cache && (strpos($_SERVER['QUERY_STRING'], 'NOCACHE') === false)) {
			$cache->save();
		}
		if (!$this->keep_alive) {
			$this->close();
		}
	}

}