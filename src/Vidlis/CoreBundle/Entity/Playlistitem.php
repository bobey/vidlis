<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="playlistitem")
 */
class Playlistitem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idVideo;

    /**
     * @ORM\ManyToOne(targetEntity="Playlist", inversedBy="items", cascade={"remove"})
     * @ORM\JoinColumn(name="idPlaylist", referencedColumnName="id")
     */
    private $idPlaylist;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $idPlaylist
     */
    public function setIdPlaylist($idPlaylist)
    {
        $this->idPlaylist = $idPlaylist;
    }

    /**
     * @return mixed
     */
    public function getIdPlaylist()
    {
        return $this->idPlaylist;
    }

    /**
     * @param mixed $idVideo
     */
    public function setIdVideo($idVideo)
    {
        $this->idVideo = $idVideo;
    }

    /**
     * @return mixed
     */
    public function getIdVideo()
    {
        return $this->idVideo;
    }

} 