<?php
require_once('api_twitch.php');
require_once('api_own3d.php');

$ownChannel = '340254';
$twitchChannel = 'tsm_dyrus';

$own = new Own3dChannel($ownChannel);
$twitch = new TwitchChannel($twitchChannel);

echo 'Property dump:<br>';

foreach($own as $property => $value) {
    echo "\$own.$property = ".htmlspecialchars($value)."<br>";
}

foreach($twitch as $property => $value) {
    echo "\$twitch.$property = ".htmlspecialchars($value)."<br>";
}

?>