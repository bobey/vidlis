<?php

namespace Vidlis\CoreBundle\Twig;

use MyProject\Proxies\__CG__\stdClass;

class VidlisExtension extends \Twig_Extension
{
    private $youtubeServiceVideo;

    public function __construct($youtubeVideoService)
    {
        $this->youtubeServiceVideo = $youtubeVideoService;
    }

    public function getFilters()
    {
        return array(
            'makeClickable' => new \Twig_Filter_Method($this, 'makeClickable', array('is_safe' => array('html'))),
            'videoImage' => new \Twig_Filter_Method($this, 'videoImage'),
            'videoTitle' => new \Twig_Filter_Method($this, 'videoTitle'),
            'videoPercentageLike' => new \Twig_Filter_Method($this, 'videoPercentageLike'),
            'videoLikeCount' => new \Twig_Filter_Method($this, 'videoLikeCount'),
            'videoDislikeCount' => new \Twig_Filter_Method($this, 'videoDislikeCount'),
            'videoViewCount' => new \Twig_Filter_Method($this, 'videoViewCount'),
            'isFloat' => new \Twig_Filter_Method($this, 'isFloat'),
        );
    }

    /**
     * Make clickable link in a text
     * @param $text
     * @return mixed
     */
    public function makeClickable($text)
    {
        return preg_replace('@(?<![.*">])\b(?:(?:https?|ftp|file)://|[a-z]\.)[-A-Z0-9+&#/%=~_|$?!:,.]*[A-Z0-9+&#/%=~_|$]@i', '<a href="\0" target="_blank">\0</a>', $text);
    }

    /**
     * Return the medium image of a video
     * @param $idVideo
     * @return mixed
     */
    public function videoImage($idVideo)
    {
        $result = $this->youtubeServiceVideo->setId($idVideo)->getResult();
        if (count($result->items)) {
            return $result->items[0]->snippet->thumbnails->medium->url;
        } else {
            return false;
        }
    }

    /**
     * Return the title of a video
     * @param $idVideo
     * @return mixed
     */
    public function videoTitle($idVideo)
    {
        $result = $this->youtubeServiceVideo->setId($idVideo)->getResult();
        if (count($result->items)) {
            return $result->items[0]->snippet->title;
        } else {
            return false;
        }
    }

    /**
     * @param $idVideo
     * @return float
     */
    public function videoPercentageLike($idVideo)
    {
        $result = $this->youtubeServiceVideo->setId($idVideo)->getResult();
        if (count($result->items)) {
            $item = $result->items[0];
            $total = $item->statistics->likeCount + $item->statistics->dislikeCount;
            return ($item->statistics->likeCount / $total * 100);
        } else {
            return 0;
        }
    }

    /**
     * @param $idVideo
     * @return int
     */
    public function videoDislikeCount($idVideo)
    {
        $result = $this->youtubeServiceVideo->setId($idVideo)->getResult();
        if (count($result->items)) {
            $item = $result->items[0];
            return number_format($item->statistics->dislikeCount, 0, ',', ' ');
        } else {
            return 0;
        }
    }

    /**
     * @param $idVideo
     * @return int
     */
    public function videoLikeCount($idVideo)
    {
        $result = $this->youtubeServiceVideo->setId($idVideo)->getResult();
        if (count($result->items)) {
            $item = $result->items[0];
            return number_format($item->statistics->likeCount, 0, ',', ' ');
        } else {
            return 0;
        }
    }


    /**
     * @param $idVideo
     * @return int
     */
    public function videoViewCount($idVideo)
    {
        $result = $this->youtubeServiceVideo->setId($idVideo)->getResult();
        if (count($result->items)) {
            $item = $result->items[0];
            return number_format($item->statistics->viewCount, 0, ',', ' ');
        } else {
            return 0;
        }
    }

    public function isFloat($number)
    {
        return is_float($number);
    }

    public function getName()
    {
        return 'vidlis_extension';
    }
}
