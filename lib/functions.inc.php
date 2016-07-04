<?PHP
use gries\Rcon\MessengerFactory;
use gries\Rcon\Messenger;

class ArkInfo {

	static function getPlayers(){
		$messenger = MessengerFactory::create(RCON_HOST, RCON_PORT, RCON_PASSWORD);
		$players = array();
		// send a message and parse the command via. a callable
		$response = $messenger->send('ListPlayers');
		$regex = "/(\d+)\. (.*), (\d+)/";
		foreach(explode("\n", $response) as $arg){
			if(!$arg){ continue; }

			preg_match($regex, $arg, $m);
			$players[$m[1]] = array("SteamID" => $m[3], "Name" => $m[2]);
		}
		return $players;

	}

	static function getUrlCached($url, $cachetime = 43200){
		$cachefile = CACHEDIR."/ark_cache.".md5($url);

		if (file_exists($cachefile) &&
			(time() - filemtime($cachefile) < $cachetime ) // 12 hours
			&& !isset($_GET['regen'])
		){
			//echo ("<!-- Using Cached Content for $url -->");
			$json = file_get_contents($cachefile);
		} else {
			//echo ("<!-- Using New Content for $url -->");
			$json = file_get_contents($cachefile);
			//die("Getting new content");
			//die($cachefile);
			$json = file_get_contents($url);
			$fp = fopen($cachefile, "w");
			fwrite($fp, $json);
			fclose($fp);
		}
		return $json;

	}

	static function getSteamProfiles($id){

		if(is_array($id)){
			$id = implode(",", $id);
		}
		$url = sprintf("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=%s&format=json&steamids=%s", STEAM_API_KEY, $id);
		
		$json = ArkInfo::getUrlCached($url);

		$data = json_decode($json);
		$players = array();
		foreach($data->response->players as $player){
			$players[$player->steamid] = $player;
		}
		return $players;

	}

}
