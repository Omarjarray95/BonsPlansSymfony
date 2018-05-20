<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notif")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seen;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $icon;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $iconColor;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Notification constructor.
     * @param $date
     * @param $content
     * @param $seen
     * @param $icon
     * @param $iconColor
     * @param $user
     */
    public function __construct($content, $icon, $iconColor, $user)
    {
        $this->date = new \DateTime();
        $this->content = $content;
        $this->seen = 0;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
        $this->user = $user;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param mixed $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getIconColor()
    {
        return $this->iconColor;
    }

    /**
     * @param mixed $iconColor
     */
    public function setIconColor($iconColor)
    {
        $this->iconColor = $iconColor;
    }


}
