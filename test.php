<?php
require('lib/config.php');
$cookieData		= explode('|', file_get_contents('./data/'.$cookieFile));
$cookie 		= $cookieData[0]; // Cookie Instagram
$useragent 		= $cookieData[1]; // Useragent Instagram
$loop			= true;
//feed/user/{$userId}/story/
echo "
 ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        🅼🅰🆂🆂 🅻🅾🅾🅺🅴🆁 
	$---------$--------$
	1.Mass story views without Action block
	2.Reacts to stories
	3.Auto Poll reactions
	4.Auto Question Ansewring
	$---------$--------$
	
	\n";
	/*
echo "[o] $$$$$$$$$$ Auto  Story Viewer by Photolooz $$$$$$$$$$$$$$$$$$ [o]\n";
echo "  $----$----$ Author nthanfp Modified by 🤑 @mohsanjid 🤑 $----$---$   \n\n";
echo " Subscribe my Youtube channel $ PhotoLooz $ for more videos --😍
 \n\n";*/

if($cookie){
	$getakun	= proccess(1, $useragent, 'accounts/current_user/', $cookie);
	$getakun	= json_decode($getakun[1], true);
	if($getakun['status'] == 'ok'){
		//LOSS
		$getakunV2	= proccess(1, $useragent, 'users/'.$getakun['user']['pk'].'/info', $cookie);
		$getakunV2	= json_decode($getakunV2[1], true);
		echo "[~] Login as @".$getakun['user']['username']." \n";
		echo "[~] [Media : ".$getakunV2['user']['media_count']."] [Follower : ".$getakunV2['user']['follower_count']."] [Following : ".$getakunV2['user']['following_count']."]\n";
		echo "[~] Please wait 5 second for loading script\n";
		echo "[~] "; for($x = 0; $x <= 4; $x++){ echo "========"; sleep(1); } echo "\n\n";
		do {
			$targets	= file_get_contents('./data/'.$targetFile);
			$targets 	= explode("\n", str_replace("\r", "", $targets));
			$targets 	= array($targets)[0];
			foreach($targets as $target){
				$komens		= file_get_contents('./data/'.$answerFile);
				$komen		= explode("\n", str_replace("\r", "", $komens));
				$komen		= array($komen)[0]; // a list of answers
				//
				$todays		= file_get_contents('./data/daily/'.date('d-m-Y').'.txt');
				$today		= explode("\n", str_replace("\r", "", $todays));
				$today		= array($today)[0];
				//
				//$proxy		= file_get_contents('https://veonpanel.com/api/panel/proxy?key=MEMEF');
				//$proxy		= json_decode($proxy, true);
				//$prox['ip']			= $proxy['data']['proxy'];
				$prox['ip']			= 0;
				$prox['user']		= 0;
				$prox['is_socks5']	= 0;
				$reels		= array();
				$reels_suc	= array();
				$listids = [37832521535];
				for($i = 0; $i < count($listids); $i++):
					echo "\n\nsearching user id: ".$listids[$i]." ...\n";
					$getstory   = proccess(1, $useragent, 'feed/user/'.$listids[$i].'/story/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
					$getstory   = json_decode($getstory[1], true);
					var_dump($getstory);
					echo "media_count: ".$getstory['reel']['media_count']."\n";
					foreach($getstory['reel']['items'] as $storyitem):
						$reels[count($reels)]	= $storyitem['id']."_".$getstory['reel']['user']['pk'];
						$stories['id']			= $storyitem['id'];
						$stories['reels']		= $storyitem['id']."_".$getstory['reel']['user']['pk'];
						$stories['reel']		= $storyitem['taken_at'].'_'.time();
						//if(strpos(file_get_contents('./data/storyData.txt'), $stories['reels']) == false){
							//var_dump($storyitem);
							echo "\n***story id: ".$storyitem['id']."\n";
							echo "user: ".$storyitem["user"]["username"]."\n";
							if(isset($storyitem["location"]))
								echo "location: ".$storyitem["location"]["name"]."\n";
							if(isset($storyitem["story_hashtags"]))
								echo "tag: ".$storyitem["story_hashtags"][0]["hashtag"]["name"]."\n";
							if(isset($storyitem["story_polls"])) {
								$poll = $storyitem["story_polls"][0]["poll_sticker"];
								echo "poll: ".$poll["question"]."\n";
								echo "tallies: ".$poll["tallies"][0]["text"]." or ".$poll["tallies"][1]["text"]."\n";
							}
							if(isset($storyitem["story_sliders"])) {
								$slider = $storyitem["story_sliders"][0]["slider_sticker"];
								echo "slider: ".$slider["question"]." - ".$slider["emoji"]."\n";
							}
							if(isset($storyitem["story_questions"])) {
								$question = $storyitem["story_questions"][0]["question_sticker"];
								echo "question: ".$question["question"]."\n";
							}
							if(isset($storyitem["story_quizs"])) {
								$quiz = $storyitem["story_quizs"][0]["quiz_sticker"];
								echo "quiz: ".$quiz["question"]." - ";
								foreach ($quiz["tallies"] as $key => $tallies) {
									echo $tallies["text"]." ";
								}
								echo "\n";
							}
							if(isset($storyitem["story_countdowns"])) {
								$countdown = $storyitem["story_countdowns"][0]["countdown_sticker"];
								echo "countdown: ".$countdown["text"]."\n";
							}

							if(isset($storyitem["creative_config"]) && isset($storyitem["creative_config"]["effect_preview"])) {
								$effect = $storyitem["creative_config"]["effect_preview"];
								echo "effect: ".$effect["name"]."\n";
								echo "effect_id: ".$effect["id"]."\n";
							}
							if(isset($storyitem["reel_mentions"])) {
								echo "mentions: ";
								foreach ($storyitem["reel_mentions"] as $key => $mentions) {
									echo $mentions["user"]["username"]." ";
								}
								echo "\n";
							}

							if(isset($storyitem["image_versions2"]))
								echo "image: ".$storyitem["image_versions2"]["candidates"][0]["url"]."\n";
							if(isset($storyitem["video_versions"]))
								echo "video: ".$storyitem["video_versions"][0]["url"]."\n";
							

							echo "\n=== processing action ===\n";

							$hook       = '{"live_vods_skipped": {}, "nuxes_skipped": {}, "nuxes": {}, "reels": {"'.$stories['reels'].'": ["'.$stories['reel'].'"]}, "live_vods": {}, "reel_media_skipped": {}}';
							$viewstory  = proccess_v2(1, $useragent, 'media/seen/?reel=1&live_vod=0', $cookie, hook(''.$hook.''), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
							$viewstory  = json_decode($viewstory[1], true);
							if($storyitem['story_polls']){
								$stories['pool_id']	= $storyitem['story_polls'][0]['poll_sticker']['poll_id'];
								$react_1	  		= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['pool_id'].'/story_poll_vote/', $cookie, hook('{"radio_type": "none", "vote": "'.rand(0,1).'"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_1			= json_decode($react_1[1], true);
								if($react_1['status'] == 'ok'){
									echo "[~] ".date('d-m-Y H:i:s')." - Success polling for ".$stories['id']."\n";
								}
								echo "[Stories Polls True : ".$stories['pool_id']." : ".$react_1[1]."] \n";
							}
							if($storyitem['story_questions']){
								$stories['question_id']	= $storyitem['story_questions'][0]['question_sticker']['question_id'];
								$rand					= rand(0, count($komen)-1);
						        $textAnswer 			= $komen[$rand];
								$react_2	  			= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['question_id'].'/story_question_response/', $cookie, hook('{"response": "'.$textAnswer.'", "type": "text"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_2				= json_decode($react_2[1], true);
								if($react_2['status'] == 'ok'){
									echo "[~] ".date('d-m-Y H:i:s')." - Question answer for ".$stories['id']." : ".$textAnswer." \n";
								}
								echo "[Stories Question True : ".$stories['question_id']." : ".$react_2[1]."] \n";
							}
							if($storyitem['story_countdowns']){
								$stories['countdown_id']	= $storyitem['story_countdowns'][0]['countdown_sticker']['countdown_id'];
								$react_3	  				= proccess(1, $useragent, 'media/'.$stories['countdown_id'].'/follow_story_countdown/', $cookie, 0, array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_3					= json_decode($react_3[1], true);
								echo "[Stories Countdown True : ".$stories['countdown_id']." : ".$react_3[1]."] \n";
							}
							if($storyitem['story_sliders']){
								$stories['slider_id']	= $storyitem['story_sliders'][0]['slider_sticker']['slider_id'];
								$react_4	  			= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['slider_id'].'/story_slider_vote/', $cookie, hook('{"radio_type": "wifi-none", "vote": "0.8"}'), array(), $prox['ip'], $prox['user'], $prox['is_socks5']);
								$react_4				= json_decode($react_4[1], true);
								if($react_2['status'] == 'ok'){
									echo "[~] ".date('d-m-Y H:i:s')." - Success sent slider for ".$stories['id']."\n";
								}
								echo "[Stories Slider True : ".$stories['slider_id']." : ".$react_4[1]."] \n";
							}
							/*if($storyitem['story_quizs']){
								$stories['quiz_id']	= $storyitem['story_quizs'][0]['quiz_sticker']['quiz_id'];
								$react_5	  		= proccess(1, $useragent, 'media/'.$stories['id'].'/'.$stories['quiz_id'].'/story_poll_vote/', $cookie, hook('{"radio_type": "none", "vote": "'.rand(0,count($storyitem['story_quizs'][0]['quiz_sticker']["tallies"])-1).'"}'));
								echo "[Stories Quiz True : ".$stories['quiz_id']." : ".$react_5[1]."] \n";
							}*/
							if($viewstory['status'] == 'ok'){
								$reels_suc[count($reels_suc)] = $storyitem['id']."_".$getstory['reel']['user']['pk'];
								echo "[~] ".date('d-m-Y H:i:s')." - Seen stories ".$stories['id']." \n";
								//saveData('./data/storyData.txt', $stories['reels']);
								//saveData('./data/daily/'.date('d-m-Y').'.txt', $stories['reels']);
							}
							sleep($sleep_1);
						//}
						var_dump($stories);
					endforeach;
					echo "[~] ".date('d-m-Y H:i:s')." - Sleep for ".$sleep_2." second to bypass instagram limit\n"; sleep($sleep_2);
				endfor;
				echo "[~] ".count($reels)." story from ".$target." collected\n";
				echo "[~] ".count($reels_suc)." story from ".$target." marked as seen\n";
				echo "[~] ".count($today)." story reacted today\n";
				echo "[~] ".date('d-m-Y H:i:s')." - Sleep for 30 second to bypass instagram limit\n";
				echo "[~] "; for($x = 0; $x <= 4; $x++){ echo "========"; sleep(6); } echo "\n\n";
			}
			echo "{$maxCountPerDay} > {$today}\n";
			if(count($today) > $maxCountPerDay){
				echo "[~] ".count($today)." story reacted today\n";
				echo "[~] Limit instagram api 2000 seen/day\n";
				echo "[~] Sleep for 20 hours to bypass instagram limit\n";
				sleep(72000);
				echo "[~] End sleep...\n\n";
			}
		} while($loop == true);
	} else {
		echo "[!] Error : ".json_encode($getakun)."\n";
	}
} else {
	echo "[!] Please login\n";
}
?>
