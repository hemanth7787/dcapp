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
		$items = NewsData::all();
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
			$news = new NewsData();
			$news->newsTitle = $element[0]->newsTitle;
			$news->imageURL = $element[0]->imageURL;
			$news->newsURL = $element[0]->newsURL;
			$news->newsDesc = $element[0]->newsDesc;
			$news->newsDetail = $element[0]->newsDetails;
			$news->newsDate = $element[0]->newsDate;
			$news->save();
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
