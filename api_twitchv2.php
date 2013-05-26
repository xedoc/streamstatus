<?php

require_once('http.php');

class TwitchChannel {

    private $apiUrl = 'https://api.twitch.tv/kraken/streams/';

    public function __construct($channel) {
        $this->channel = $channel;
        $this->apiUrl .= $this->channel;
        $this->Refresh();
    }

    public function Refresh() {
        if (strlen($this->channel) == 0) {
            return;
        }
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n"
            )
        );
        $context = stream_context_create($opts);
        $this->jsonData = file_get_contents($this->apiUrl, false, $context);
        $this->ReadJSON();
    }

    private function ReadJSON() {
        try {
            $json = json_decode($this->jsonData, true);
            if (!isset($json["stream"]))
                return;
            $stream = $json["stream"];
            $this->BroadcasterSoftwareName = (string) $stream["broadcaster"];
            $channel = $stream["channel"];
            $this->ID = (string) $channel["_id"];
            $this->URL = (string) $channel["url"];
            $this->Game = (string) $channel["game"];
            $this->DisplayName = (string) $channel["display_name"];
            $this->Title = (string) $channel["status"];
            $this->UpdatedAt = (string) $channel["updated_at"];
            $this->CreatedAt = (string) $channel["created_at"];
            unset($this->jsonData); //We do not want the jsonData displayed.
        } catch (Exception $e) {
            
        }
    }

}

?>
