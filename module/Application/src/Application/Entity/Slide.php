<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 6/6/2014
 * Time: 5:17 μμ
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Slide
 * @package Application\Entity
 * @ORM\Entity(repositoryClass="\Application\Repository\SlideRepository")
 * @ORM\Table(name="slides")
 */
class Slide {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", length=5, name="slide_id")
     */
    private $slideId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer", length=3)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $caption;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $thumbnail;

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $slideId
     */
    public function setSlideId($slideId)
    {
        $this->slideId = $slideId;
    }

    /**
     * @return mixed
     */
    public function getSlideId()
    {
        return $this->slideId;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


} 