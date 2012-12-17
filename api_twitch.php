<?php 

require_once('http.php');

class TwitchChannel
{
	private $xml, $wc, $dom, $channel;
	private $apiUrl = 'http://api.justin.tv/api/stream/list.xml?channel=';
	
	public $IsLive = false;
	public $Game, $Viewers, $Bitrate, $Title;
	public $EmbedCode, $EmbedEnabled;
	public $ImgHuge, $ImgLarge, $ImgMedium, $ImgSmall, $ImgTiny;
	public $ScrHuge, $ScrLarge, $ScrMedium, $ScrSmall;
	
	
	public function __construct($channel) {
		$this->channel = $channel;
		$this->apiUrl .= $this->channel;
		$this->wc = new WebClient();
		$this->Refresh();
	}
	
	public function Refresh() {
		$this->IsLive = false;
		if( strlen( $this->channel ) == 0 ) {
		    return;
		}	
		$suffix = strpos( $this->apiUrl, '?' )===false?'?t='.time():'&t='.time();
		$this->xml = $this->wc->get( $this->apiUrl.$suffix );
		$this->ReadXML();
	}
	private function ReadXML() {
	    try{
    		$this->dom = new SimpleXMLElement($this->xml);
			
			if( !isset($this->dom->stream) )
				return;
			$stream = $this->dom->stream;
			$this->Title = (string) $stream->title;
			$this->IsLive = (boolean) ( strtolower( $stream->stream_type ) == strtolower( 'live' ) );
			$this->Game = (string) $stream->meta_game;
			$this->Viewers = (int) $stream->stream_count;
			$this->Bitrate = (float) $stream->video_bitrate;
			
			$channel = $stream->channel;
			$this->EmbedCode = (string) $channel->embed_code;
			$this->EmbedEnabled = (boolean) $channel->embed_enabled;
			$this->ImgHuge = (string) $channel->image_url_huge;
			$this->ImgLarge = (string) $channel->image_url_large;
			$this->ImgMedium = (string) $channel->image_url_medium;
			$this->ImgSmall = (string) $channel->image_url_small;
			$this->ImgTiny = (string) $channel->image_url_tiny;
			
			$this->ScrHuge = (string) $channel->screen_cap_url_huge;
			$this->ScrLarge = (string) $channel->screen_cap_url_large;
			$this->ScrMedium = (string) $channel->screen_cap_url_medium;
			$this->ScrSmall = (string) $channel->screen_cap_url_small;
	    }
	    catch( Exception $e ){
	    }
	    
	}
}

?>