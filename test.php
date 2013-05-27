<?php
//require_once('api_twitch.php'); //Justin.tv API
require_once('api_twitchv2.php'); //Twitch.tv API
$twitchChannel = 'achiedetectedhd';
$twitch = new TwitchChannel($twitchChannel);

echo 'Property dump:<br>';
foreach(object2array($twitch) as $property => $value) {
    echo "\$twitch.".$property." = ".$value."</br>";
}

function object2array($obj) { 
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj; 
    foreach ($_arr as $key => $val) { 
        $val = (is_array($val) || is_object($val)) ? object2array($val) : $val; 
        $arr[$key] = $val; 
    } 
    return $arr; 
}  

?>