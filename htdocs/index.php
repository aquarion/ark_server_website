<?PHP

require('../library/PHP-Source-Query-Class/SourceQuery/SourceQuery.class.php');
#require __DIR__ . '/../library/PHP-Source-Query-Class/SourceQuery/bootstrap.php';
#       use xPaw\SourceQuery\SourceQuery;

	define( 'SQ_SERVER_ADDR', '172.17.0.1' );
	define( 'SQ_SERVER_PORT', 27015 );
	#define( 'SQ_SERVER_PORT', 32330 );
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
