<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoingEvent
 *
 * @ORM\Table(name="going_event")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\GoingEventRepository")
 */
class GoingEvent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Evenement")
     */
    private $event;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return GoingEvent
     */
    public function setUser(\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set event
     *
     * @param \MainBundle\Entity\Evenement $event
     *
     * @return GoingEvent
     */
    public function setEvent(\MainBundle\Entity\Evenement $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \MainBundle\Entity\Evenement
     */
    public function getEvent()
    {
        return $this->event;
    }
}
