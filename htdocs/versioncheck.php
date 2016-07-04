<?PHP

require('../vendor/autoload.php');
require("../config.php");
require("../lib/functions.inc.php");

use xPaw\SourceQuery\SourceQuery;


define( 'SQ_SERVER_ADDR', SERVER_IP );
define( 'SQ_SERVER_PORT', SERVER_PORT );
define( 'SQ_TIMEOUT',     1 );
define( 'SQ_ENGINE',      SourceQuery :: SOURCE );


$Query = new SourceQuery( );

try
{
	$Query->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );
	if(!$Query->GetInfo()){
		throw new Exception('Could not contact server');
	}
}
catch( Exception $e )
{
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	echo $e->getMessage( );
	die();
}
	
$latest = ArkInfo::getUrlCached("http://arkdedicated.com/version", 60*60);

$info    = $Query->GetInfo( );

$ver_match = preg_match("/\(v(.*)\)/", $info['HostName'], $matches);

if ($ver_match && floor($matches[1]) == floor($latest)) {
	echo $matches[1]." ~= ".$latest;
} else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

	echo "Out of date (Us: ".floor($matches[1]).") != (Them: ".floor($latest).")";
}

$Query->Disconnect( );
