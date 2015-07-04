<!DOCTYPE html>
<?php

require_once dirname(__FILE__)."/src/phpfreechat.class.php";
$params = array();
$params["title"] = "Chatter";
$params["nick"] = "guest".rand(1,1000);  // setup the intitial nickname
$params['firstisadmin'] = true;
//$params["isadmin"] = true; // makes everybody admin: do not use it on production servers ;)
$params["serverid"] = md5(__FILE__); // calculate a unique id for this chat
$params["debug"] = false;
$chat = new phpFreeChat( $params );

?>
<html>
<head>
	<meta charset="utf-8">
	<title>Floydian Lands - IF Forever Wandering</title>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
	</script>
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<style>
		body {font-family: Verdana, sans-serif; font-size:0.8em;}
		header,nav, section,article,footer
		{border:1px solid grey; margin:5px; padding:8px;}
		nav ul {margin:0; padding:0;}
		nav ul li {display:inline; margin:5px;}
	</style>
</head>

<body>
	<div id="wrapper">
		<header>
			<nav>Test | Things | All | Go | Here</nav>
		</header>
		<div id="gargoyle"><img src="http://i.imgur.com/KPGUhid.jpg?1" /><br />
		All Things Must be Tested.</div>
		<div id="chat"><?php $chat->printChat(); ?>
		  <?php if (isset($params["isadmin"]) && $params["isadmin"]) { ?>
		    <p style="color:red;font-weight:bold;">Warning: because of "isadmin" parameter, everybody is admin. Please modify this script before using it on production servers !</p>
		  <?php } ?>
		  No, really, all of them.</div>
		<div id="command">We're not kidding here.</div>
	</div>
</body>
</html>