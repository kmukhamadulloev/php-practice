<?php

/* CONFIG */
require('config.php');
/* END: CONFIG */

/* DATABASE */

$pdo = false;
try {
	if (!empty($CONFIG['pdo']['options'])) {
		$pdo = new PDO(
			$CONFIG['pdo']['dsn'],
			$CONFIG['pdo']['username'],
			$CONFIG['pdo']['password'],
			$CONFIG['pdo']['options']
		);
	} else {
		$pdo = new PDO(
			$CONFIG['pdo']['dsn'],
			$CONFIG['pdo']['username'],
			$CONFIG['pdo']['password']
		);
	}

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	addLog("UR DATABASE SUCKZ CUZ " . $e->getMessage());
	exit(1);
}

/* END: DATABASE */

/* FUNCTIONS */
function addLog($text) {
	$ts = date("H:i:s");
	// echo "[{$ts}]: {$text}\n";
}

function get($url, $ref=false) {
	global $CONFIG;
	$ch = curl_init();
	addLog ("HTTP  GET: " . $url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_USERAGENT, $CONFIG['useragent']);
	if ($ref) {
		curl_setopt($ch, CURLOPT_REFERER, $ref);
	}
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch, CURLOPT_TIMEOUT, 40);
	// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	// curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:1080");
	// curl_setopt($ch, CURLOPT_PROXY, "192.168.220.100:3128");
	$res = curl_exec($ch);
	
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$httpurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	
	if (curl_errno($ch) != 0) {
		// var_dump("Curl error", curl_error($ch));
		// var_dump("Curl errcode", curl_errno($ch));
	}
	
	curl_close($ch);
	
	if ($httpcode==302 && (stripos($httpurl, 'imgur.com/removed.')!==FALSE || stripos($httpurl, 'imgur.com/gallery.')!==FALSE)){
		return false;
	} else {
		return $res;
	}
}

function imgurAPI($url) {
	global $CONFIG;
	$ch = curl_init();
	addLog ("IMGUR: " . $url);
	curl_setopt($ch, CURLOPT_URL, $CONFIG['imgur']['base'] . $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization: Client-ID {$CONFIG['imgur']['client']}",
		"Accept: application/json"
	));
	curl_setopt($ch, CURLOPT_USERAGENT, $CONFIG['useragent']);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	// curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:1080");
	// curl_setopt($ch, CURLOPT_PROXY, "192.168.220.100:3128");
	$res = curl_exec($ch);
	curl_close($ch);
	return json_decode($res);
}

function getImgurAlbum($albumId) {
	$album = imgurAPI("/gallery/album/{$albumId}/images");
	// // var_dump($album);
	
	if ($album !== false) {
		$urls = array();
		
		foreach ($album->data as $image) {
			$urls[] = $image->link;
		}
		
		return $urls;
	} else {
		return false;
	}
}

function getImagesByUrl ($url) {
	if (preg_match("/imgur\.com\/([\w]{3,10})$/", $url, $output_array)) {
		return array("https://i.imgur.com/{$output_array[1]}.jpg");
	}
	
	if (preg_match("#imgur\.com/(a|album|gallery)/(\w{1,20})#", $url, $output_array)) {
		return getImgurAlbum($output_array[2]);
	}
	
	if (preg_match("/.*\.(jpe?g|png)$/", $url)) {
		return array($url);
	}

	return false;
}

function vkAPI ($method, $options = array()) {
	global $CONFIG;
	
	$specialFields = array(
		// "publish_date" => "12122020",
		"access_token" => $CONFIG['vk']['token'],
		"v"            => "5.81",
		"lang"         => "ru"
	);
	
	$options = ($options === false) ? array() : $options;
	if (!is_array($options)) return false;
	
	$data = array_merge($options, $specialFields);
	
	$result = post("https://api.vk.com/method/{$method}", $data);
	$result = json_decode($result);
	
	if (!$result) return false;
	if (isset($result->error)) {
		addLog("VKAPI Error");
		// // var_dump($result);
		return false;
	}
	usleep(300000);
	return $result;
}

function tgAPI ($method, $options = array()) {
	global $CONFIG;
	
	$token = $CONFIG['tg']['token'];
	
	$options = ($options === false) ? array() : $options;
	if (!is_array($options)) return false;
	
	$result = post("https://api.telegram.org/bot{$token}/{$method}", $options);
	$result = json_decode($result);
	
	if (isset($result->ok) && $result->ok===FALSE){
		addLog("TGAPI Error");
		// var_dump($result);
		return false;
	}
	
	usleep(300000);
	return $result;
}

function post($url, $data) {
	global $CONFIG;
	$ch = curl_init(); 
	addLog("HTTP POST: " . $url);
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_USERAGENT, $CONFIG['useragent']);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	// curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:1080");
	// curl_setopt($ch, CURLOPT_PROXY, "192.168.220.100:3128");
	$res = curl_exec($ch);
	// var_dump($res);
	curl_close($ch);
	return $res;
}

function vkFile($url, $filePath) {
	global $CONFIG;
	$ch = curl_init(); 
	addLog("HTTP POST: " . $url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_USERAGENT, $CONFIG['useragent']);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	$fileObject = new CURLFile($filePath, 'image/jpeg', 'image.jpg');
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('file1' => $fileObject));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	// curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	// curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:1080");
	// curl_setopt($ch, CURLOPT_PROXY, "192.168.220.100:3128");
	$res = curl_exec($ch);
	$res = json_decode($res);
	curl_close($ch);
	return $res;
}

function imageArrayToVk ($imageArray) {
	global $CONFIG;
	
	if ($imageArray !== FALSE) {
		$resultArray = array();
		foreach ($imageArray as $image) {
			addLog("Uploading image:: {$image}");
			$imageData = get($image);
			if ($imageData !== FALSE) {
				$imagePath = sys_get_temp_dir() . "/r2vk_" . md5($image) . ".jpg";
				$imageSave = @file_put_contents($imagePath, $imageData);
				if ($imageSave === FALSE) {
					addLog("Your disk sucks");
					return false;
				}

				$vkUploadServer = vkAPI(
					"photos.getWallUploadServer",
					array(
						'group_id' => $CONFIG['vk']['group']
					)
				);
				
				if ($vkUploadServer === FALSE) {
					addLog('vk sucks');
					return false;
				}
				
				$vkUploadUrl = $vkUploadServer->response->upload_url;
				
				$vkUploadResult = vkFile($vkUploadUrl, $imagePath);
				
				if ($vkUploadResult === FALSE) {
					addLog('vkUpload sucks');
					return false;
				}
				
				$vkSavePhotoResult = vkAPI(
					"photos.saveWallPhoto",
					array(
						'group_id' => $CONFIG['vk']['group'],
						'photo'    => $vkUploadResult->photo,
						'server'   => $vkUploadResult->server,
						'hash'     => $vkUploadResult->hash
					)
				);
				
				if ($vkSavePhotoResult === FALSE) {
					addLog('save photo failed');
					return false;
				}
				
				// var_dump($vkSavePhotoResult);
				
				$photoId = $vkSavePhotoResult->response[0]->id;
				$ownerId = $vkSavePhotoResult->response[0]->owner_id;
				$resultId = "photo{$ownerId}_{$photoId}";
				
				$resultArray[] = $resultId;
				unlink($imagePath);
			} else {
				addLog("Pic sucks");
				return false;
			}
		}
		
		return implode(',', $resultArray);
	} else {
		addLog("Your internet sucks");
		return false;
	}
}

function handleSubreddit($subreddit) {
	global $CONFIG, $pdo;
	
	addLog("starting handling subreddit: {$subreddit}");
	# requesting feed
	$json = get("https://www.reddit.com/r/{$subreddit}/.json");
	$json = json_decode($json);

	# getting list of posts
	if ($json !== false && isset($json->data->children)) {
		$publishedPosts = 0;
		$maxPosts = 1;
		
		foreach ($json->data->children as $post) {
			$id = $post->data->id;
			$title = $post->data->title;
			$url = $post->data->url;
			
			// echo "{$id}:\t{$title}\n{$url}\n\n";
			
			// check DB for `id` duplicates
			try {
				$stmt = $pdo->prepare("SELECT id FROM anipixart WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				
				$cnt = $stmt->rowCount();
			} catch (PDOException $e) {
				addLog("hey, our database fucked up on selection");
				continue;
			}
			
			if ($cnt > 0) {
				addLog('post is already handled');
				continue;
			}
			
			$images = getImagesByUrl($url);
			$attachments = imageArrayToVk($images);
			// var_dump("Attachments", $attachments);
			
			if (!($attachments && strlen($attachments) > 0)) {
				addLog('post sucks, it haz no picturez');
				continue;
			}

			$postResult = vkAPI(
				'wall.post',
				array(
					'owner_id' => '-' . $CONFIG['vk']['group'],
					'from_group' => 1,
					'message' => "{$title}\nURL: http://redd.it/{$id}",
					'attachments' => $attachments		
				)
			);

			// var_dump("Post Result", $postResult);
			
			$result = ($postResult !== FALSE) ? 'ok' : 'error';
			
			// TODO: save $result ['ok', 'error'] to DB
			try {
				$stmt = $pdo->prepare("INSERT INTO anipixart(id, result) VALUES (:id, :result)");
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':result', $result);
				$stmt->execute();
			} catch (PDOException $e) {
				addLog("hey, our database fucked up on insertion");
				continue;
			}
			
			if ($result == 'ok') {
				if ($publishedPosts++ >= $maxPosts - 1) {
					return false;
				}
			}
		}
	} else {
		// echo "Malformed JSON response";
	}
}
	
/* END: FUNCTIONS */

if (!isset($CONFIG['subreddits'])) {
	addLog("Gimme moar subreddits!");
	exit;
}

$randomSubreddit = $CONFIG['subreddits'][array_rand($CONFIG['subreddits'])];
handleSubreddit($randomSubreddit);
// handleSubreddit('awwnime');

