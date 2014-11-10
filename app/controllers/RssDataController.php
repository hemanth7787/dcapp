<?php

class RssDataController extends \BaseController {

	/**
	 * Display a listing of the news.
	 *
	 * @return Response
	 */
	 public function index()
	{
		return '';
	}
	public function news()
	{
		$this->updateNewsXML();
		$items = NewsData::all()->slice(0, 50);
		return Response::json($items);
	}
	public function events()
	{
		
		$this->updateEventsXML();
		$items = EventsData::all();
		return Response::json($items);
		
	}
	private function updateNewsXML(){
		$newsURL =  "http://www.dubaichamber.com/rss_news.php";	
		$simplexml = $this->readCURL($newsURL);
		
		foreach($simplexml as $element){
			$news_url_hash = hash('ripemd160', $element[0]->newsURL+$element[0]->newsTitle+$element[0]->newsDate);
			$news = NewsData::firstOrNew(array("url_hash"=>$news_url_hash));
			// check if news is already saved to database
			if(!$news->exists)
			{
				$news->newsTitle = $element[0]->newsTitle;
				$news->imageURL = $element[0]->imageURL;
				$news->newsURL = $element[0]->newsURL;
				$news->newsDesc = $element[0]->newsDesc;
				$news->newsDetail = $element[0]->newsDetails;
				$news->newsDate = $element[0]->newsDate;
				$news->url_hash = $news_url_hash;
				$news->save();
			}
			else
			{
				// if the latest news item is already saved in Database
				// we can skip all others.
				//break;
				//error_log($news->newsURL);
			}
		}
	}
	private function updateEventsXML(){
		$eventsURL =  "http://www.dubaichamber.com/rss_events.php";	
		$simplexml = $this->readCURL($eventsURL);
		foreach($simplexml as $element){
			$events = new EventsData();
			$events->eventTitle = $element[0]->eventTitle;
			$events->eventURL = $element[0]->eventURL;
			$events->eventDesc = $element[0]->eventDesc;
			$events->eventDate = $element[0]->eventDate;
			$events->eventAboutTitle = $element[0]->eventAboutTitle;
			$events->eventAboutDesc = $element[0]->eventAboutDesc;
			$events->eventAgendaTitle = $element[0]->eventAgendaTitle;
			$events->eventAgendaDesc = $element[0]->eventAgendaDesc;
			$events->eventSpeakerTitle = $element[0]->eventSpeakerTitle;
			$events->eventSpeakerDesc = $element[0]->eventSpeakerDesc;
			$events->eventImgURL = $element[0]->eventImgURL;
			$events->save();
		}
	}
   private function readCURL($URL){
	   	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		$sxe = new SimpleXMLElement($server_output);
		return $sxe;
   }

	

}
