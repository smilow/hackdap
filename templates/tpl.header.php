<?

$this->javascript[] = 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js';
//$this->javascript[] = '/ui/main.js';
//$this->css[] = '/ui/main.css';

echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><head>');
$this->meta();
$this->css();
echo('</head><body><noscript>'.SITE_NAME.' works best with javascript and cookies.</noscript>');
