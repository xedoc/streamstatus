<?php 

require_once('http.php');

class Own3dChannel
{
	private $xml, $wc, $dom;
	private $apiUrl = 'http://api.own3d.tv/live';
	private $guidPrefix = 'http://www.own3d.tv/live/';

	public $IsLive, $Game, $Viewers, $Title, $Channel, $Guid, $Thumbnail;	
	
	public function __construct($channel) {
		$this->Channel = $channel;
		$this->Guid = $this->guidPrefix.$this->Channel;
		//$this->apiUrl .= $this->Channel;
		$this->wc = new WebClient();
		$this->Refresh();
	}
	
	public function Refresh() {
		$this->IsLive = false;
		if( strlen( $this->Channel ) == 0 ) {
		    return;
		}	
		$suffix = strpos( $this->apiUrl, '?' )===false?'?t='.time():'&t='.time();
		$this->xml = $this->wc->get( $this->apiUrl.$suffix );
		$this->ReadXML();
	}
	private function ReadXML() {
	    try{
    		$this->dom = new SimpleXMLElement($this->xml);
			foreach ($this->dom->channel->item as $item) {
				if (strtolower($this->Guid) == strtolower( (string) $item->guid) ) {
					$this->IsLive = true;
					$this->Game = (string) $item->misc['game'];
					$this->Viewers = (int) $item->misc['viewers'];
					$this->Title = (string) $item->title;
					$this->Thumbnail = (string) $item->thumbnail;
				}
			}
	    }
	    catch( Exception $e ){
	    }
	    
	}
}

?>