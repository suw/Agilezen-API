<?php

declare(encoding='UTF-8');

class Agilezen {

	private $json = NULL;
	private $parameterList = array();
	private $withList = array();
	private $url = NULL;

	const AGILEZEN_API_URL = 'https://agilezen.com/api/v1/';

	public function __construct($apiKey) {
		if ( !function_exists('json_decode') ) {
			throw new \Exception('You must have the latest version of PHP with the json_decode() function.');
		}
		
		$this->parameterList = array(
			'apikey' => $apiKey,
			'pageSize' => 1000
		);
	}

	public function with($item) {
		$item = strtolower($item);
		if ( 'everything' == $item ) {
			$this->withList = array($item);
		} elseif ( !in_array($item, $this->withList) ) {
			$this->withList[] = $item;
		}
		return $this;
	}
	
	public function getProjectList() {
		$this->buildUrl('projects');
		$this->execute();
		
		return $this->json->projects;
	}
	
	public function getStoryList($projectId) {
		$this->buildUrl('project', $projectId, 'stories');
		$this->execute();
		
		return $this->json->items;
	}
	
	public function getStory($projectId, $storyId) {
		$this->buildUrl('project', $projectId, 'story', $storyId);
		$this->execute();
		
		return $this->json;
	}
	
	private function execute() {
		if ( empty($this->url) ) {
			throw new \Exception('Failed to execute call to Agilezen, the URL is not defined.');
		}
		
		$this->connect()
			->connectOptions()
			->connectExecute()
			->connectClose();
		
		$this->json = json_decode($this->json);
		
		return $this;
	}
	
	private function buildUrl() {
		$argv = func_get_args();
		$argc = count($argv);
		
		$this->url = self::AGILEZEN_API_URL;
		
		if ( $argc > 0 ) {
			$this->url .= implode('/', $argv);
		}
		
		if ( count($this->withList) > 0 ) {
			$this->parameterList['with'] = implode(',', $this->withList);
		}
		
		if ( count($this->parameterList) > 0 ) {
			$urlParameters = http_build_query($this->parameterList);
			$this->url .= "?{$urlParameters}";
		}
	}

	private function connect() {
		$this->curl = curl_init($this->url);
		return $this;
	}
	
	private function connectOptions() {
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		return $this;
	}
	
	private function connectExecute() {
		$this->json = curl_exec($this->curl);
		return $this;
	}
	
	private function connectClose() {
		curl_close($this->curl);
		return $this;
	}
}