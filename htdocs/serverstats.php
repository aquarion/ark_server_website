<?PHP
$latest = file_get_contents("http://arkdedicated.com/version");
$info    = $Query->GetInfo( );
$players = $Query->GetPlayers( );
$rules   = $Query->GetRules( );
#$stats	 = $Query->Rcon('stats');

$ver_match = preg_match("/\(v(.*)\)/", $info['HostName'], $matches);

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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">

    <h1><?PHP echo $info['ModDesc'] ?>: <?PHP echo $info['HostName'] ?></h1>

<?PHP
if ($ver_match && floor($matches[1]) == floor($latest)) {

} else {
	echo '<div class="alert alert-warning">Server update pending</div>';
}

?>
<p>Welcome to the ARK Experiment, where the local time is <?PHP echo $rules['DayTime_s'] ?>. 
In the case of an emergency, exits are located nowhere. Good luck. 
[<a href="steam://connect/ark.ludo.istic.net:27015">Launch Steam & Connect</a>]</p>
<?PHP
printf('<h2>Connected Players: %d/%d</h2>', $info['Players'], $info['MaxPlayers']);
foreach($players as $player){
	if(!$player['Name']){
		print('<h3>[Connecting...]</h3>');
	} else {
		printf('<h3>%s</h3>', $player['Name']);
	}	
	printf("<p>Connection time: %s", $player['TimeF']);

	
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



