<?PHP

require('../vendor/autoload.php');
require("../lib/functions.inc.php");
require("../config.php");

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
	#$Query->SetRconPassword( SERVER_PASSWORD );
	#var_dump( $Query->Rcon( 'say hello' ) );
	include("serverstats.php");
}
catch( Exception $e )
{
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	echo $e->getMessage( );
}

$Query->Disconnect( );
