<?PHP

$latest = ArkInfo::getUrlCached("http://arkdedicated.com/version", 60*60);
$info    = $Query->GetInfo( );
$players = $Query->GetPlayers( );
$rules   = $Query->GetRules( );
#$stats	 = $Query->Rcon('stats');
$ver_match = preg_match("/\(v(.*)\)/", $info['HostName'], $matches);

// setup the messenger

$rconPlayers = ArkInfo::getPlayers();

$ids = array();
foreach($rconPlayers as $player){
	$ids[] = $player["SteamID"];
}

$steamProfiles = ArkInfo::getSteamProfiles($ids);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ark Server Stuff</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<style type="text/css">
@import url(http://weloveiconfonts.com/api/?family=zocial);

/* zocial */
[class*="zocial-"]:before {
  font-family: 'zocial', sans-serif;
}

.btn-steam { 
  color: #ffffff; 
  background-color: #000000; 
  border-color: #130269; 
} 
 
.btn-steam:hover, 
.btn-steam:focus, 
.btn-steam:active, 
.btn-steam.active, 
.open .dropdown-toggle.btn-steam { 
  color: #ffffff; 
  background-color: #49247A; 
  border-color: #130269; 
} 
 
.btn-steam:active, 
.btn-steam.active, 
.open .dropdown-toggle.btn-steam { 
  background-image: none; 
} 
 
.btn-steam.disabled, 
.btn-steam[disabled], 
fieldset[disabled] .btn-steam, 
.btn-steam.disabled:hover, 
.btn-steam[disabled]:hover, 
fieldset[disabled] .btn-steam:hover, 
.btn-steam.disabled:focus, 
.btn-steam[disabled]:focus, 
fieldset[disabled] .btn-steam:focus, 
.btn-steam.disabled:active, 
.btn-steam[disabled]:active, 
fieldset[disabled] .btn-steam:active, 
.btn-steam.disabled.active, 
.btn-steam[disabled].active, 
fieldset[disabled] .btn-steam.active { 
  background-color: #000000; 
  border-color: #130269; 
} 
 
.btn-steam .badge { 
  color: #000000; 
  background-color: #ffffff; 
}

.btn-facebook { 
  color: #FFFFFF; 
  background-color: #3B5998; 
  border-color: #0e1f56; 
} 
 
.btn-facebook:hover, 
.btn-facebook:focus, 
.btn-facebook:active, 
.btn-facebook.active, 
.open .dropdown-toggle.btn-facebook { 
  color: #FFFFFF; 
  background-color: #0E1F56; 
  border-color: #0e1f56; 
} 
 
.btn-facebook:active, 
.btn-facebook.active, 
.open .dropdown-toggle.btn-facebook { 
  background-image: none; 
} 
 
.btn-facebook.disabled, 
.btn-facebook[disabled], 
fieldset[disabled] .btn-facebook, 
.btn-facebook.disabled:hover, 
.btn-facebook[disabled]:hover, 
fieldset[disabled] .btn-facebook:hover, 
.btn-facebook.disabled:focus, 
.btn-facebook[disabled]:focus, 
fieldset[disabled] .btn-facebook:focus, 
.btn-facebook.disabled:active, 
.btn-facebook[disabled]:active, 
fieldset[disabled] .btn-facebook:active, 
.btn-facebook.disabled.active, 
.btn-facebook[disabled].active, 
fieldset[disabled] .btn-facebook.active { 
  background-color: #3B5998; 
  border-color: #0e1f56; 
} 
 
.btn-facebook .badge { 
  color: #3B5998; 
  background-color: #FFFFFF; 
}

.btn-red { 
  color: #FFFFFF; 
  background-color: #CC1E36; 
  border-color: #0E1F56; 
} 
 
.btn-red:hover, 
.btn-red:focus, 
.btn-red:active, 
.btn-red.active, 
.open .dropdown-toggle.btn-red { 
  color: #FFFFFF; 
  background-color: #E30D0D; 
  border-color: #0E1F56; 
} 
 
.btn-red:active, 
.btn-red.active, 
.open .dropdown-toggle.btn-red { 
  background-image: none; 
} 
 
.btn-red.disabled, 
.btn-red[disabled], 
fieldset[disabled] .btn-red, 
.btn-red.disabled:hover, 
.btn-red[disabled]:hover, 
fieldset[disabled] .btn-red:hover, 
.btn-red.disabled:focus, 
.btn-red[disabled]:focus, 
fieldset[disabled] .btn-red:focus, 
.btn-red.disabled:active, 
.btn-red[disabled]:active, 
fieldset[disabled] .btn-red:active, 
.btn-red.disabled.active, 
.btn-red[disabled].active, 
fieldset[disabled] .btn-red.active { 
  background-color: #CC1E36; 
  border-color: #0E1F56; 
} 
 
.btn-red .badge { 
  color: #CC1E36; 
  background-color: #FFFFFF; 
}

.player-info > h3 {
	margin-top: .2em;
}

</style>

  </head>
  <body>
    <div class="container">

    <h1><?PHP echo $info['ModDesc'] ?>: <?PHP echo $info['HostName'] ?></h1>

<?PHP
if ($ver_match && $matches[1] == $latest) {
	printf('<div class="alert alert-success">[%s] Server is up to date</div>', $latest);

} elseif ($ver_match && floor($matches[1]) == floor($latest)) {
	printf('<div class="alert alert-warning">[%s] Minor version mismatch. Usually this doesn\'t need a server update, but poke admins if something\'s broken</div>', $latest);

} else {
	printf('<div class="alert alert-danger">[%s] Server update pending</div>', $latest);
}

?>
<p>Welcome to the ARK Experiment, where the local time is <?PHP echo $rules['DayTime_s'] ?>. 
In the case of an emergency, exits are located nowhere. Good luck. </p>
<div class="btn-group">
	<a href="steam://connect/ark.ludo.istic.net:27015" class="btn btn-lg btn-steam"><span class="zocial-steam"></span> Launch Steam &amp; Connect</a> 
	<a href="http://steamcommunity.com/app/346110/discussions/0/594820656447032287/" class="btn btn-lg btn-red"><i class="glyphicon glyphicon-fire"> </i> Patch Notes</a> 
	<a href="https://www.facebook.com/groups/ARKitecture/" class="btn btn-lg btn-facebook"><span class="zocial-facebook"></span> FB Group</a> 

</div>
<?PHP
printf('<h2>Connected Players: %d/%d</h2>', $info['Players'], $info['MaxPlayers']);
foreach($players as $player){

	echo "<div class=\"row  no-gutter\">";
	
	if(!$player['Name']){
		print('<h3>[Connecting...]</h3>');
	} else {
		$rcon = $rconPlayers[$player['Id']];
		$steam = $steamProfiles[$rcon['SteamID']];
		printf('<div class="col-md-1"><img src="%s" alt="Avatar for %s" class="img-rounded"></div>', $steam->avatarmedium, $player['Name']);
		echo '<div class="col-md-5 player-info">';
		printf('<h3><a href="%s">%s</a></h3>', $steam->profileurl, $player['Name']);
		printf("<p>Connection time: %s", $player['TimeF']);
		/*echo "<pre>";
		var_dump($rcon);
		var_dump($steam);
		var_dump($player);
		echo "</pre>";
		echo "</div>";
		echo "</div>";*/
	}	
	
}
#var_dump($info);
#var_dump($players);
#var_dump($rules);
#var_dump($stats);
?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>



