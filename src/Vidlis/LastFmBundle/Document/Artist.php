<?php
namespace Vidlis\LastFmBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Artist {

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\String
     */
    private $name;

    /**
     * @MongoDB\EmbedMany(targetDocument="Album")
     */
    private $albums = array();

    /**
     * @MongoDB\String
     */
    private $info;

    /**
     * @MongoDB\EmbedMany(targetDocument="Tag")
     */
    private $tags = array();

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $info
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    public function addAlbum(Album $album)
    {
        foreach ($this->albums as $albumAlready) {
            if ($albumAlready->getMbid() == $album->getMbid()) {
                return $this;
            }
        }
        $this->albums[] = $album;
        return $this;
    }

    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

}