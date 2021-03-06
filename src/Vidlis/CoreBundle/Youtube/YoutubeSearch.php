<?php
namespace Vidlis\CoreBundle\Youtube;


class YoutubeSearch {
    
    private $url = 'https://www.googleapis.com/youtube/v3/search?';
    
    private $key;
    
    private $part = 'snippet';
    
    private $maxResults = 50;
    
    private $q;
    
    private $regionCode;
    
    private $type = 'video';

    private $memcacheService;
    
    public function __construct($memcacheService, $apiKey)
    {
        $this->key = $apiKey;
        $this->regionCode = 'FR';
        $this->memcacheService = $memcacheService;
    }


    public function setQuery($q)
    {
        $this->q = urlencode($q);
        return $this;
    }
    
    public function getUrlSearch() 
    {
        $url = $this->url.'part='.$this->part
               .'&type='.$this->type
               .'&maxResults='.$this->maxResults
               .'&q='.$this->q
               .'&regionCode='.$this->regionCode
               .'&key='.$this->key;
        
        return $url;
    }
    
    public function getResults()
    {
        $result = $this->memcacheService->get($this->q);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlSearch()));
            $this->memcacheService->set($this->q, $result, 900);
        }
        return $result;
    }
}

