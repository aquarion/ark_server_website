<?PHP

require('../library/PHP-Source-Query-Class/SourceQuery/SourceQuery.class.php');
#require __DIR__ . '/../library/PHP-Source-Query-Class/SourceQuery/bootstrap.php';
#       use xPaw\SourceQuery\SourceQuery;

	define( 'SQ_SERVER_ADDR', '172.17.0.1' );
	define( 'SQ_SERVER_PORT', 27015 );
	//define( 'SQ_SERVER_PORT', 201444445 );
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
	

$latest = file_get_contents("http://arkdedicated.com/version");
$info    = $Query->GetInfo( );

$ver_match = preg_match("/\(v(.*)\)/", $info['HostName'], $matches);

if ($ver_match && floor($matches[1]) == floor($latest)) {
	echo $matches[1]." ~= ".$latest;
} else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

	echo "Out of date (Us: ".floor($matches[1]).") != (Them: ".floor($latest).")";
}

$Query->Disconnect( );
