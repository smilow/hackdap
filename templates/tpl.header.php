<?

$this->javascript[] = 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js';
$this->javascript[] = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js';
$this->css[] = '/dcweek/assets/css/bootstrap.min.css';
$this->css[] = '/dcweek/assets/css/backgrounds_color.css';
$this->css[] = '/dcweek/assets/css/main.css';
//$this->javascript[] = '/ui/main.js';
//$this->css[] = '/ui/main.css';

echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><head>');
$this->meta();
$this->css();
echo('</head><body><noscript>'.SITE_NAME.' works best with javascript and cookies.</noscript>');
?>
<header>
<div class="container">
<div id="logo">
<p class="pageTitle"><a href="/"><span>SmartResponse</span>.org</a></p>
<ul class="inline-list" id="quickNav">
<li><a href="/" class="earthquakes">earthquakes</a></li>
<li><a href="/" class="tsunamis">tsunamis</a></li>
<li><a href="/" class="fires">fires</a></li>
<li><a href="/" class="hurricanes">hurricanes</a></li>
</ul>
</div>
<div id="donate">
<a href="get-involved/donate.html" class="button"><span>Make a Donation</span></a>
</div>
</div>
</header>

<nav id="navigation">
<div class="container">
<ul class="inline-list" id="mainNav">
<li><a href="why-accountability/key-issues.html"><span>Why Accountability?</span></a><span class="arrow"></span></li>
<li class="on"><a href="what-we-do/"><span>What We Do</span></a><span class="arrow"></span></li>
<li><a href="dispatches/all-dispatches/"><span>Dispatches</span></a><span class="arrow"></span></li>
<li><a href="get-involved/"><span>Get Involved</span></a><span class="arrow"></span></li>
<li><a href="news-media/"><span>News + Media</span></a><span class="arrow"></span></li>
<li><a href="about-us/"><span>About Us</span></a><span class="arrow"></span></li>
<li><a href="/blog2/"><span>Read Our Blog</span></a><span class="arrow"></span></li>
</ul>
</div>
</nav>
<nav id="navigationSecondary">
<div class="container">
<ul class="inline-list" id="secondaryNav">
<ul><li class="first active on"><a title="Relief Oversight Initiative" href="what-we-do/relief-oversight.html">Relief Oversight Initiative</a></li>
<li><a title="Disaster Policy Wiki" href="what-we-do/policy.html">Disaster Policy Wiki</a></li>
<li><a title="Real-Time Hotline" href="what-we-do/real-time-hotline.html">Real-Time Hotline</a></li>
<li class="last"><a title="Citizen Engagement" href="what-we-do/citizen-engagement.html">Citizen Engagement</a></li>
</ul>
</ul>
</div>
</nav>