<?php
// make a request to the site
function request($settings) {
    $settingsList = ['url', 'method', 'data', 'decode'];
    foreach ($settingsList as $setting) {
        if(!isset($settings[$setting])){
            $settings[$setting] = null;
        }
    }
    // create a new cURL resource
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $settings['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $settings['data']['v'] = VK_API_VERSION;
    if($settings['method'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        if($settings['data']) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $settings['data']);
        }
    } elseif($settings['data']) {
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($settings['data']));
    }
    $response = curl_exec($ch);
    // grab URL and pass it to the browser
    // close the connection, release resources used
    curl_close($ch);
    if($settings['decode'] === false) {
        return $response; 
    }

    return json_decode($response, true);
}
/** Get a token **/
function getAuthorizeUrl() {
    $params = http_build_query([
        'client_id'     => CLIENT_ID,
        'scope'         => 'groups, wall, offline, photos',
        'redirect_uri'  => REDIRECT_URI,
        'response_type' => 'code',
    ]);
    $url = urldecode("https://oauth.vk.com/authorize?$params");
    return $url;
}
// Request token from VK
function requestToken() {
    $params = [
        'client_id'     => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'code'          => $_GET['code'],
        'redirect_uri'  => REDIRECT_URI,
    ];
    $token = request(['url' => "https://oauth.vk.com/access_token", 'method' => 'GET', 'data' => $params]);
    return $token;
}

function getToken() {
    $rq = requestToken();
    /**
     * If we get error when requesting error
     * just need to reload the page,
     * because we have expired code
     **/
    if(isset($rq['error'])) {
        header('Location: '. strtok($_SERVER['REQUEST_URI'], '?'));
    }
    return $rq['access_token'];
}

/** Post on the wall **/

function attachImage($groupID, $photo, $hash, $server) {
    $params = [
        'group_id' => $groupID,
        'photo'    => $photo,
        'hash'     => $hash,
        'server'   => $server,
        'access_token' => ACCESS_TOKEN,
    ];
    return request(['url' => 'https://api.vk.com/method/photos.saveWallPhoto', 'method' => 'GET', 'data' => $params]);
}

function uploadImages($images, $groupID) {
    $params = [
        'group_id' => $groupID,
        'access_token' => ACCESS_TOKEN,
    ];
    $response = request(['url' => 'https://api.vk.com/method/photos.getWallUploadServer', 'method' => 'POST', 'data' => $params])['response'];

    // Add 1, because file starts from 1
    $imagesLink = [];
    $imagesCnt = count($images)+1;
    for($i = 1; $i < $imagesCnt; $i++) {
        $imagesLink['file'.$i] = curl_file_create($images[$i-1]);
    }
    $images = request(['url' => $response['upload_url'], 'data' => $imagesLink, 'method' => 'POST']);

    $images = attachImage($params['group_id'], $images['photo'], $images['hash'], $images['server'])['response'];
    /** 
        Converting images response
        to "photo{owner_id}_{image_id}"
    **/
    $images = array_map(function($image) {
        return "photo{$image['owner_id']}_{$image['pid']}";
    }, $images);
    // Split photo links by comma
    return implode($images, ', ');
}


function wallPost($groups, $text, $images) {
    $cntGropus = count($groups);
    for($i = 0; $i < $cntGropus; $i++) {
        post($groups[$i], $text, $images);
        sleep(1);
    }
    clearImagesDirectory();
}

function post($groupID, $text, $images) {
//	var_dump($groupID);
    $params = [
        'message' => $text,
        'owner_id' => '-'.$groupID,
        'access_token' => ACCESS_TOKEN,
    ];
    if(!empty($images)) {
        $params['attachments'] = uploadImages($images, $groupID);
    }

    request(['url' => 'https://api.vk.com/method/wall.post', 'method' => 'POST', 'data' => $params]);
}

function getGroupsIdByName(array $groups) {
    $groups = array_map(function($group) {
        if(strpos($group, 'public') !== false) {
            $group = (int) preg_replace('/\D/', '', $group);
        }
        return $group;
    }, $groups);
    $params = [
        'group_ids' => $groups,
    ];
    $groups = request(['url' => 'https://api.vk.com/method/groups.getById', 'data' => $params])['response'];

    $groups = array_map(function($group) {
        return $group['gid'];
    }, $groups);
    var_dump($groups);
    return $groups;
}

function clearImagesDirectory() {
    if ($handle = opendir(IMAGES_DIR)) {
        while (false !== ($file = readdir($handle))) { 
            if ($file != "." && $file != "..") { 
                unlink(IMAGES_DIR."/".$file);
            } 
        }
        closedir($handle); 
    }
}